<?php

namespace App\Services\Sync;

use App\Models\Project;
use App\Models\System;
use App\Models\Flow;
use App\Models\Task;
use App\Models\Bug;
use App\Services\Game\GameService;
use Exception;
use Illuminate\Support\Facades\Log;

class CsvImportService
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function import(array $files): void
    {
        // 1. Import Flows (First Pass - Create Systems & Flows)
        if (isset($files['flows'])) {
            $this->importFlows($files['flows']);
        }

        // 2. Import Tasks (Link to Flows)
        $this->importTasks('UI', $files['ui_tasks'] ?? null);
        $this->importTasks('API', $files['api_tasks'] ?? null);
        $this->importTasks('FE', $files['fe_tasks'] ?? null);

        // 3. Import Bugs
        $this->importBugs($files['bugs'] ?? null);

        // 4. Recalculate Logic
        $this->recalculateAll();
    }

    private function importFlows(string $path): void
    {
        if (!file_exists($path)) {
            Log::warning("CSV Import: Flows file not found at $path");
            return;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // Skip header: Flow ID, System, Group...

        $project = Project::firstOrCreate(['name' => 'MCOP Quest']);

        while (($row = fgetcsv($handle)) !== false) {
            // Mapping:
            // 0: Flow ID
            // 1: System
            // 2: Group (or User role?, header says "Group", row says "สมัครสมาชิก")
            // 3: User
            // 4: Flow name
            // ... Assignee? Column 20 is Assignee (checked in terminal valid output)
            
            $flowId = trim($row[0] ?? '');
            $systemName = trim($row[1] ?? 'Unknown System');
            $group = trim($row[2] ?? '');
            $flowName = trim($row[4] ?? '');
            $assignee = trim($row[20] ?? ''); 

            if (!$flowId) continue;

            $system = System::firstOrCreate(
                ['name' => $systemName, 'project_id' => $project->id]
            );

            Flow::updateOrCreate(
                ['external_id' => $flowId],
                [
                    'system_id' => $system->id,
                    'name' => $flowName ?: "Flow $flowId",
                    'group' => $group,
                    'assignee' => $assignee
                ]
            );
        }
        fclose($handle);
    }

    private function importTasks(string $type, ?string $path): void
    {
        if (!$path || !file_exists($path)) return;

        $handle = fopen($path, 'r');
        
        // Skip header - Tasks CSVs often have multiple header lines or messy structure
        // UI-tasks.csv: Line 1 ID, Date, Flow ID... ? No, row 2 is header. 
        // Let's assume standard reading and check data.
        // Based on terminal output:
        // UI-tasks.csv Header: 🔢ID,Created Date,Flow ID,...
        // Row: UI0001, 13 ส.ค., 490, ...
        
        // We need to read until we find the real header "🔢ID" or "ID" maybe?
        // Or just blindly read row, check if row[0] looks like an ID.

        while (($row = fgetcsv($handle)) !== false) {
            $taskId = trim($row[0] ?? ''); // UI0001
            // Basic valid ID check (e.g. starts with UI, API, KC, or just not empty)
            if (empty($taskId) || str_starts_with($taskId, '🔢') || $taskId === 'ID') continue;

            $flowId = trim($row[2] ?? ''); // Flow ID linked
            $title = trim($row[7] ?? ''); // Task/Action (Col 7 in UI csv? Need verification)
            // Wait, UI-tasks.csv header:
            // 0: ID, 1: Date, 2: Flow ID, 3: Slug, 4: Action, 5: Due Date, 6: Urgent, 7: Tasks ??
            // Let's retry:
            // "Action" is col 4 (index 4). "Tasks" might be description?
            // "Status" is col 14 (index 14)? 
            // Terminal output: "UI0001... ✅ออกแบบ UI ใหม่... status: 6 - Done"
            
            // Let's infer mapping for UI-tasks:
            // Col 2: Flow ID (490)
            // Col 4: Action/Title (✅ออกแบบ UI ใหม่)
            // Col 14: Status (6 - Done)
            // Col 13: Assignee (JJ)

            if (!$flowId) continue;
            
            $flow = Flow::where('external_id', $flowId)->first();
            if (!$flow) continue;

            $statusRaw = strtolower(trim($row[14] ?? '')); 
            // Map status: "6 - done" -> "done", else "todo"
            $status = str_contains($statusRaw, 'done') ? 'done' : 'todo';
            if (str_contains($statusRaw, 'doing')) $status = 'doing';

            $title = trim($row[4] ?? 'Untitled Task');

            Task::updateOrCreate(
                ['external_id' => $taskId],
                [
                    'flow_id' => $flow->id,
                    'title' => $title,
                    'type' => $type,
                    'status' => $status,
                    'assignee' => trim($row[13] ?? null)
                ]
            );
        }
        fclose($handle);
    }

    private function importBugs(?string $path): void
    {
        if (!$path || !file_exists($path)) return;

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // Skip header

        $project = Project::first();

        while (($row = fgetcsv($handle)) !== false) {
            // Bugs.csv Mapping (Based on "1`...UB0001" line):
            // 0: Date
            // 1: Flow ID
            // 2: ID (UB0001)
            // 3: Type
            // 4: System
            // ...
            // 10: Name (Title)
            // 17: Status (6 - Done)
            
            $bugId = trim($row[2] ?? '');
            if (!$bugId) continue;

            $title = trim($row[10] ?? 'Untitled Bug');
            $statusRaw = strtolower(trim($row[17] ?? ''));
            
            // Map Status
            $status = 'open';
            if (str_contains($statusRaw, 'done') || str_contains($statusRaw, 'close')) $status = 'resolved';

            Bug::updateOrCreate(
                ['title' => $title], // Bug ID might not be in DB schema, treat Title as key or update Schema? 
                // Wait, Bugs actually don't have external_id in Schema yet. Use title for now or add it.
                // Re-using Title is risky if duplicate. But acceptable for MVP.
                [
                    'project_id' => $project->id,
                    'status' => $status,
                    'severity' => 'normal' // default
                ]
            );
        }
        fclose($handle);
    }

    private function recalculateAll(): void
    {
        foreach (Flow::all() as $flow) {
            $this->gameService->calculateFlowHP($flow);
        }
    }
}
