<?php

namespace App\Livewire\Pages;

use App\Models\Flow;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CommanderDetail extends Component
{
    public int $commanderId;

    public ?Flow $flow = null;

    public array $tasks = [];

    public array $progress = [];

    public array $team = [];

    public function mount(int $id): void
    {
        $this->commanderId = $id;
        $this->loadFlowData();
    }

    private function loadFlowData(): void
    {
        $this->flow = Flow::with(['system', 'tasks'])->findOrFail($this->commanderId);

        $this->tasks = $this->flow->tasks->toArray();

        $this->progress = [
            'design' => $this->flow->hp_design,
            'ac' => $this->flow->hp_ac,
            'api' => $this->flow->hp_api,
            'fe' => $this->flow->hp_fe,
            'testing' => $this->flow->hp_testing,
            'uat' => $this->flow->hp_uat,
        ];

        $this->team = $this->buildTeamFromTasks();
    }

    private function buildTeamFromTasks(): array
    {
        $team = [];
        $assignees = collect($this->tasks)
            ->pluck('assignee')
            ->filter()
            ->unique()
            ->values();

        foreach ($assignees as $assignee) {
            $tasksForAssignee = collect($this->tasks)
                ->where('assignee', $assignee);

            $type = $this->getAssigneeType($tasksForAssignee);

            $team[] = [
                'name' => $assignee,
                'initial' => strtoupper(substr($assignee, 0, 1)),
                'type' => $type,
                'type_icon' => $this->getTypeIcon($type),
                'color' => $this->getTypeColor($type),
                'task_count' => $tasksForAssignee->count(),
            ];
        }

        return $team;
    }

    private function getAssigneeType($tasks): string
    {
        $types = $tasks->pluck('type')->filter()->unique()->values();

        if ($types->contains('API')) {
            return 'API';
        }
        if ($types->contains('UI')) {
            return 'UI';
        }
        if ($types->contains('FE')) {
            return 'FE';
        }

        return 'General';
    }

    private function getTypeIcon(string $type): string
    {
        return match ($type) {
            'API' => '⚙️',
            'UI' => '🎨',
            'FE' => '💻',
            default => '👤',
        };
    }

    private function getTypeColor(string $type): string
    {
        return match ($type) {
            'API' => '#9B59B6',
            'UI' => '#E67E22',
            'FE' => '#1ABC9C',
            default => '#95A5A6',
        };
    }

    public function getOverallProgress(): int
    {
        if (! $this->flow) {
            return 0;
        }

        $total = $this->flow->hp_design
            + $this->flow->hp_ac
            + $this->flow->hp_api
            + $this->flow->hp_fe
            + $this->flow->hp_testing
            + $this->flow->hp_uat;

        return (int) round($total / 6);
    }

    public function getStatusLabel(): string
    {
        $progress = $this->getOverallProgress();

        return match (true) {
            $progress >= 100 => 'Victory',
            $progress >= 80 => 'In Battle',
            $progress >= 50 => 'Wounded',
            $progress >= 30 => 'Critical',
            default => 'Preparing',
        };
    }

    public function getStatusColor(): string
    {
        $progress = $this->getOverallProgress();

        return match (true) {
            $progress >= 100 => 'success',
            $progress >= 80 => 'warning',
            $progress >= 50 => 'info',
            $progress >= 30 => 'warning',
            default => 'danger',
        };
    }

    public function getTasksByType(string $type): array
    {
        return collect($this->tasks)
            ->where('type', $type)
            ->values()
            ->toArray();
    }

    public function getTaskCountsByType(): array
    {
        $types = ['UI', 'API', 'FE'];
        $counts = [];

        foreach ($types as $type) {
            $typeTasks = $this->getTasksByType($type);
            $done = collect($typeTasks)->where('status', 'done')->count();
            $total = count($typeTasks);

            $counts[$type] = [
                'total' => $total,
                'done' => $done,
                'pending' => $total - $done,
            ];
        }

        return $counts;
    }

    public function render()
    {
        return view('livewire.pages.commander-detail');
    }
}
