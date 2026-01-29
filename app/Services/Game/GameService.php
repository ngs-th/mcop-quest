<?php

namespace App\Services\Game;

use App\Models\Flow;
use App\Models\Task;

class GameService
{
    /**
     * Calculate 6 HP Bars based on Minion (Task) status.
     * Logic:
     * - UI Tasks count towards Design HP
     * - API Tasks count towards API HP
     * - FE Tasks count towards FE HP
     * - AC, Testing, UAT are usually updated directly in Sheets (for now assume Manual or Task-based if mapped)
     * For Prototype: We calculate purely based on Tasks count.
     * Percentage = (Done Tasks / Total Tasks) * 100
     */
    public function calculateFlowHP(Flow $flow): void
    {
        $flow->hp_design = $this->calculatePercentage($flow, 'UI');
        $flow->hp_api = $this->calculatePercentage($flow, 'API');
        $flow->hp_fe = $this->calculatePercentage($flow, 'FE');
        
        // Save
        $flow->save();
    }

    private function calculatePercentage(Flow $flow, string $type): int
    {
        $total = $flow->tasks()->where('type', $type)->count();
        if ($total === 0) return 0; // Or 100 if no tasks? Assuming 0 for "No work required yet" or "Unknown"

        $done = $flow->tasks()->where('type', $type)->where('status', 'done')->count();
        
        return (int) round(($done / $total) * 100);
    }

    /**
     * Simulate "Attacking" a Minion (Completing a Task)
     */
    public function completeTask(Task $task): void
    {
        $task->update(['status' => 'done']);
        
        // Recalculate Flow HP
        if ($task->flow) {
            $this->calculateFlowHP($task->flow);
        }
    }
}
