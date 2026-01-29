<?php

namespace Tests\Feature\Sync;

use Tests\TestCase;
use App\Models\Project;
use App\Models\System;
use App\Models\Flow;
use App\Models\Task;
use App\Services\Sync\GoogleSheetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class GoogleSheetSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_command_populates_database_from_mock_sheet()
    {
        // 1. Setup Project
        $project = Project::create([
            'name' => 'MCOP Quest',
            'google_sheet_id' => 'TEST_SHEET_ID',
            'demon_king_hp' => 1000
        ]);

        // 2. Mock GoogleSheetService
        $mockService = Mockery::mock(GoogleSheetService::class);

        // Mock Flows Data
        // Cols: ID, System, Group, Name, Assignee
        $mockService->shouldReceive('getSheetData')
            ->with('TEST_SHEET_ID', 'Flows!A2:L')
            ->andReturn([
                ['F001', 'Member System', 'Auth', 'Login Flow', 'Dev1']
            ]);

        // Mock UI Tasks
        // Cols: Flow ID, Task, Assignee, Status
        $mockService->shouldReceive('getSheetData')
            ->with('TEST_SHEET_ID', 'UI-tasks!A2:F')
            ->andReturn([
                ['Login Flow', 'Design Login Screen', 'Ton', 'done']
            ]);

        // Mock API Tasks
        $mockService->shouldReceive('getSheetData')
            ->with('TEST_SHEET_ID', 'API-tasks!A2:F')
            ->andReturn([
                ['Login Flow', 'Login API', 'Ken', 'todo']
            ]);

        // Mock FE Tasks
        $mockService->shouldReceive('getSheetData')
            ->with('TEST_SHEET_ID', 'FE-tasks!A2:F')
            ->andReturn([]);

        // Mock Bugs
        $mockService->shouldReceive('getSheetData')
            ->with('TEST_SHEET_ID', 'Bugs!A2:E')
            ->andReturn([]);

        // Bind Mock
        $this->app->instance(GoogleSheetService::class, $mockService);

        // 3. Run Command
        $this->artisan('mcop:sync')
            ->assertExitCode(0);

        // 4. Assert DB State
        $this->assertDatabaseHas('systems', ['name' => 'Member System']);
        $this->assertDatabaseHas('flows', ['name' => 'Login Flow']);
        $this->assertDatabaseHas('tasks', ['title' => 'Design Login Screen', 'type' => 'UI', 'status' => 'done']);
        $this->assertDatabaseHas('tasks', ['title' => 'Login API', 'type' => 'API', 'status' => 'todo']);

        // 5. Assert Logic (HP Calculation)
        // Login Flow: 1 UI task (done), 1 API task (todo).
        // hp_design should be 100 (1/1). hp_api should be 0 (0/1).
        $flow = Flow::where('name', 'Login Flow')->first();
        $this->assertEquals(100, $flow->hp_design);
        $this->assertEquals(0, $flow->hp_api);
    }
}
