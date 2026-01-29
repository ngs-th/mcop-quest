<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\System;
use App\Models\Flow;
use App\Models\Task;
use App\Models\Bug;

class PrototypeSeeder extends Seeder
{
    public function run()
    {
        // 1. Demon King (Project)
        $project = Project::create([
            'name' => 'MCOP Quest',
            'google_sheet_id' => 'YOUR_SPREADSHEET_ID_HERE', // Placeholder
            'demon_king_hp' => 1000,
            'demon_king_max_hp' => 1000,
        ]);

        // 2. City (System)
        $city = System::create([
            'project_id' => $project->id,
            'name' => 'Member System',
            'city_hp' => 500,
            'city_max_hp' => 500,
        ]);

        // 3. Commander (Flow) - Login
        $loginFlow = Flow::create([
            'system_id' => $city->id,
            'name' => 'Login Flow',
            'group' => 'Auth Squad',
            'assignee' => 'Ken',
            'hp_design' => 50, // Partial
            'hp_ac' => 100,    // Done
            'hp_api' => 20,    // Started
            'hp_fe' => 0,
            'hp_testing' => 0,
            'hp_uat' => 0,
        ]);

        // Minions for Login Flow
        Task::create([
            'flow_id' => $loginFlow->id,
            'title' => 'Design Login Board',
            'type' => 'UI',
            'status' => 'done',
            'assignee' => 'Ton'
        ]);
        
        Task::create([
            'flow_id' => $loginFlow->id,
            'title' => 'Design Error States',
            'type' => 'UI',
            'status' => 'todo',
            'assignee' => 'Ton'
        ]);

        Task::create([
            'flow_id' => $loginFlow->id,
            'title' => 'API Auth Login',
            'type' => 'API',
            'status' => 'doing',
            'assignee' => 'Ken'
        ]);

        // 4. Commander (Flow) - Payment (Empty)
        $paymentFlow = Flow::create([
            'system_id' => $city->id,
            'name' => 'Payment Gateway',
            'group' => 'Payment Squad',
            'hp_design' => 0,
            'hp_ac' => 0,
            'hp_api' => 0,
            'hp_fe' => 0,
            'hp_testing' => 0,
            'hp_uat' => 0,
        ]);

        // 5. Demon Reinforcements (Bugs)
        Bug::create([
            'project_id' => $project->id,
            'title' => 'Login Button not clickable on Mobile',
            'status' => 'open',
            'severity' => 'high'
        ]);
    }
}
