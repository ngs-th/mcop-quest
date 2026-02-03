<?php

namespace App\Livewire\Pages;

use App\Models\System;
use App\Services\Game\RiskService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
class CityDetail extends Component
{
    #[Url]
    public int $id;

    public ?System $city = null;

    public array $flows = [];

    public array $tasks = [];

    public array $stats = [];

    public function mount(int $id): void
    {
        $this->id = $id;
        $this->loadCityData();
    }

    public function loadCityData(): void
    {
        $this->city = System::with(['flows.tasks'])->findOrFail($this->id);

        $riskService = new RiskService;

        // Load flows with calculated data
        $this->flows = $this->city->flows->map(function ($flow) {
            $hpValues = [
                $flow->hp_design,
                $flow->hp_ac,
                $flow->hp_api,
                $flow->hp_fe,
                $flow->hp_testing,
                $flow->hp_uat,
            ];

            $overallHp = (int) round(array_sum($hpValues) / count($hpValues));

            return [
                'id' => $flow->id,
                'name' => $flow->name,
                'group' => $flow->group,
                'assignee' => $flow->assignee,
                'hp_design' => $flow->hp_design,
                'hp_ac' => $flow->hp_ac,
                'hp_api' => $flow->hp_api,
                'hp_fe' => $flow->hp_fe,
                'hp_testing' => $flow->hp_testing,
                'hp_uat' => $flow->hp_uat,
                'overall_hp' => $overallHp,
                'status' => $this->getFlowStatus($overallHp, $hpValues),
                'task_count' => $flow->tasks->count(),
            ];
        })->toArray();

        // Load all tasks from all flows
        $this->tasks = $this->city->flows
            ->flatMap(fn ($flow) => $flow->tasks->map(fn ($task) => [
                'id' => $task->id,
                'title' => $task->title,
                'type' => $task->type,
                'status' => $task->status,
                'assignee' => $task->assignee,
                'flow_name' => $flow->name,
            ]))
            ->toArray();

        // Calculate stats
        $totalFlows = count($this->flows);
        $completedFlows = collect($this->flows)->where('overall_hp', 100)->count();
        $inProgressFlows = collect($this->flows)
            ->where('overall_hp', '<', 100)
            ->where('overall_hp', '>', 0)
            ->count();
        $blockedFlows = collect($this->flows)->where('overall_hp', 0)->count();

        $totalTasks = count($this->tasks);
        $completedTasks = collect($this->tasks)->where('status', 'done')->count();

        $this->stats = [
            'total_flows' => $totalFlows,
            'completed_flows' => $completedFlows,
            'in_progress_flows' => $inProgressFlows,
            'blocked_flows' => $blockedFlows,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'bugs_count' => 0, // Placeholder - to be implemented with Bug model
            'city_hp' => $this->city->city_hp ?? 100,
            'city_max_hp' => $this->city->city_max_hp ?? 500,
            'is_foggy' => $riskService->isSystemFoggy($this->city),
            'overall_hp' => $totalFlows > 0
                ? (int) round(collect($this->flows)->avg('overall_hp'))
                : 0,
        ];
    }

    private function getFlowStatus(int $overallHp, array $hpValues): string
    {
        if ($overallHp === 100) {
            return 'defeated';
        }

        if ($overallHp === 0) {
            return 'blocked';
        }

        // Check if blocked due to design/ac not ready
        if ($hpValues[0] === 0 || $hpValues[1] === 0) {
            return 'blocked';
        }

        return 'in_progress';
    }

    public function getStatusColor(int $hp): string
    {
        if ($hp >= 90) {
            return '#2ecc71'; // green
        }
        if ($hp >= 60) {
            return '#3498db'; // blue
        }
        if ($hp >= 30) {
            return '#f1c40f'; // yellow
        }

        return '#e74c3c'; // red
    }

    public function getStatusLabel(int $hp, bool $isFoggy): string
    {
        if ($isFoggy) {
            return 'Fog of War';
        }
        if ($hp >= 90) {
            return 'Health: Full';
        }
        if ($hp >= 60) {
            return 'Health: Stable';
        }
        if ($hp >= 30) {
            return 'Health: Medium';
        }

        return 'Health: Low';
    }

    public function render()
    {
        return view('livewire.pages.city-detail');
    }
}
