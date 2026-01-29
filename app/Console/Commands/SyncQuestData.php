<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Sync\GoogleSheetService;
use App\Models\Project;
use App\Models\System;
use App\Models\Flow;
use App\Models\Task;
use App\Models\Bug;
use App\Services\Game\GameService; // Using existing GameService for calculation
use Illuminate\Support\Facades\DB;

class SyncQuestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcop:sync {project_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from Google Sheets to MCOP Quest Database';

    /**
     * Execute the console command.
     */
    public function handle(GoogleSheetService $sheetService, GameService $gameService)
    {
        $this->info('Starting Quest Data Sync...');

        $projectId = $this->argument('project_id') ?? Project::first()->id;
        $project = Project::find($projectId);

        if (!$project || !$project->google_sheet_id) {
            $this->error('Project not found or Google Sheet ID missing.');
            return;
        }

        // 1. Sync Flows (Commanders)
        $this->info('Syncing Flows (Commanders)...');
        $flowsData = $sheetService->getSheetData($project->google_sheet_id, 'Flows!A2:L'); // Adjust range as needed
        
        if ($flowsData) {
            foreach ($flowsData as $row) {
                // Assuming Columns: A=ID, B=System, C=Group, D=Name, E=Assignee, F=Design, G=AC, H=API, I=FE, J=Testing, K=UAT
                // Adjust based on actual Sheet structure from user-journeys/index.html
                // flows sheet: Flow ID, System, Group, [6 status columns]
                
                $systemName = $row[1] ?? 'Unknown System';
                $system = System::firstOrCreate(
                    ['name' => $systemName, 'project_id' => $project->id]
                );

                $flow = Flow::updateOrCreate(
                    ['name' => $row[3] ?? 'Unknown Flow', 'system_id' => $system->id], // Using Name as unique for now, ideally ID
                    [
                        'group' => $row[2] ?? null,
                        'assignee' => $row[4] ?? null,
                        // Update raw status if needed, but GameService calculates HP bars from tasks
                    ]
                );
            }
        }

        // 2. Sync UI Tasks
        $this->syncTasks($sheetService, $project, 'UI', 'UI-tasks!A2:F');

        // 3. Sync API Tasks
        $this->syncTasks($sheetService, $project, 'API', 'API-tasks!A2:F');

        // 4. Sync FE Tasks
        $this->syncTasks($sheetService, $project, 'FE', 'FE-tasks!A2:F');

        // 5. Sync Bugs (Demons)
        $this->syncBugs($sheetService, $project);

        // 6. Recalculate Game State
        $this->info('Recalculating Game State (HP Bars)...');
        foreach (Flow::all() as $flow) {
            $gameService->calculateFlowHP($flow); // Use existing calculation logic
        }

        $project->update(['last_synced_at' => now()]);
        $this->info('Quest Data Sync Complete!');
    }

    private function syncTasks(GoogleSheetService $service, Project $project, string $type, string $range)
    {
        $this->info("Syncing $type Tasks...");
        $data = $service->getSheetData($project->google_sheet_id, $range);

        if (!$data) return;

        foreach ($data as $row) {
            // Mapping based on user-journeys/index.html: 
            // Flow ID, Task, Assignee, Status
            $flowName = $row[0] ?? null; // Ideally specific Flow ID
            if (!$flowName) continue;

            $flow = Flow::where('name', $flowName)->first(); // Very loose mapping, implies Flow Name must match exactly
            
            if ($flow) {
                Task::updateOrCreate(
                    [
                        'title' => $row[1] ?? 'Untitled Task',
                        'flow_id' => $flow->id,
                        'type' => $type
                    ],
                    [
                        'assignee' => $row[2] ?? null,
                        'status' => strtolower($row[3] ?? 'todo'), // Map Sheet Status to 'todo', 'doing', 'done'
                        'description' => $row[4] ?? null,
                        'url' => $row[5] ?? null
                    ]
                );
            }
        }
    }

    private function syncBugs(GoogleSheetService $service, Project $project)
    {
        $this->info('Syncing Bugs (Demons)...');
        $data = $service->getSheetData($project->google_sheet_id, 'Bugs!A2:E');

        if (!$data) return;

        foreach ($data as $row) {
            Bug::updateOrCreate(
                ['title' => $row[1] ?? 'Untitled Bug', 'project_id' => $project->id],
                [
                    'status' => $row[2] ?? 'open',
                    'severity' => $row[3] ?? 'normal'
                ]
            );
        }
    }
}
