<?php

namespace Tests\Feature\Game;

use Tests\TestCase;
use App\Models\Flow;
use App\Models\Task;
use App\Models\System;
use App\Models\Project;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_hp_calculation_logic()
    {
        // Setup
        $project = Project::create(['name' => 'Test Project']);
        $system = System::create(['name' => 'Test System', 'project_id' => $project->id]);
        $flow = Flow::create(['name' => 'Test Flow', 'system_id' => $system->id]);

        // Create tasks (2 UI tasks)
        Task::create([
            'flow_id' => $flow->id,
            'title' => 'Task 1',
            'type' => 'UI',
            'status' => 'done'
        ]);
        
        $task2 = Task::create([
            'flow_id' => $flow->id,
            'title' => 'Task 2',
            'type' => 'UI',
            'status' => 'todo'
        ]);

        // Act: Calculate
        $service = new GameService();
        $service->calculateFlowHP($flow);

        // Assert: 1/2 Done = 50%
        $this->assertEquals(50, $flow->fresh()->hp_design);
        $this->assertEquals(0, $flow->fresh()->hp_api); // No API tasks

        // Act: Complete Task 2
        $service->completeTask($task2);

        // Assert: 2/2 Done = 100%
        $this->assertEquals(100, $flow->fresh()->hp_design);
    }
}
