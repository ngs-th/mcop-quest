<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ActivityLog extends Component
{
    public array $activities = [];

    public string $filter = 'all';

    public int $page = 1;

    private const PER_PAGE = 10;

    private const ACTIVITY_ICONS = [
        'combat' => '⚔️',
        'exploration' => '🗺️',
        'social' => '👥',
        'achievement' => '🏆',
        'system' => '⚙️',
    ];

    public function mount(): void
    {
        $this->loadActivities();
    }

    public function loadMore(): void
    {
        $this->page++;
        $this->loadActivities();
    }

    public function filterByType(string $type): void
    {
        $this->filter = $type;
        $this->page = 1;
        $this->activities = [];
        $this->loadActivities();
    }

    private function loadActivities(): void
    {
        $allActivities = $this->getAllActivities();

        if ($this->filter !== 'all') {
            $allActivities = array_filter(
                $allActivities,
                fn (array $activity) => $activity['type'] === $this->filter
            );
            $allActivities = array_values($allActivities);
        }

        $offset = ($this->page - 1) * self::PER_PAGE;
        $newActivities = array_slice($allActivities, $offset, self::PER_PAGE);

        $this->activities = array_merge($this->activities, $newActivities);
    }

    private function getAllActivities(): array
    {
        return [
            [
                'id' => 1,
                'type' => 'combat',
                'icon' => self::ACTIVITY_ICONS['combat'],
                'title' => 'Task Completed',
                'description' => 'Defeated the API Minion in Flow: Login',
                'timestamp' => now()->subMinutes(2),
                'xp' => 100,
                'gold' => 50,
            ],
            [
                'id' => 2,
                'type' => 'system',
                'icon' => self::ACTIVITY_ICONS['system'],
                'title' => 'Boss HP Decreased',
                'description' => 'Boss HP dropped from 68% to 63% after task completion',
                'timestamp' => now()->subMinutes(5),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 3,
                'type' => 'combat',
                'icon' => self::ACTIVITY_ICONS['combat'],
                'title' => 'Demon Spawned!',
                'description' => 'New bug discovered: Login error when token expires',
                'timestamp' => now()->subMinutes(15),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 4,
                'type' => 'exploration',
                'icon' => self::ACTIVITY_ICONS['exploration'],
                'title' => 'Task Completed',
                'description' => 'Finished the FE implementation with animations',
                'timestamp' => now()->subMinutes(32),
                'xp' => 80,
                'gold' => 40,
            ],
            [
                'id' => 5,
                'type' => 'social',
                'icon' => self::ACTIVITY_ICONS['social'],
                'title' => 'Support Buff Applied',
                'description' => 'Completed AC review - Damage +10% for FE tasks',
                'timestamp' => now()->subHour(),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 6,
                'type' => 'achievement',
                'icon' => self::ACTIVITY_ICONS['achievement'],
                'title' => 'Commander Defeated!',
                'description' => 'All minions defeated! City Boss is 75% complete.',
                'timestamp' => now()->subHours(2),
                'xp' => 500,
                'gold' => 100,
            ],
            [
                'id' => 7,
                'type' => 'exploration',
                'icon' => self::ACTIVITY_ICONS['exploration'],
                'title' => 'Task Completed',
                'description' => 'Delivered the UI design with all edge cases covered',
                'timestamp' => now()->subHours(3),
                'xp' => 60,
                'gold' => 30,
            ],
            [
                'id' => 8,
                'type' => 'combat',
                'icon' => self::ACTIVITY_ICONS['combat'],
                'title' => 'Demon Cleared!',
                'description' => 'Email validation bug on Safari has been resolved',
                'timestamp' => now()->subHours(4),
                'xp' => 50,
                'gold' => 25,
            ],
            [
                'id' => 9,
                'type' => 'achievement',
                'icon' => self::ACTIVITY_ICONS['achievement'],
                'title' => 'Level Up!',
                'description' => 'Reached Level 15 - New skills unlocked',
                'timestamp' => now()->subDay(),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 10,
                'type' => 'system',
                'icon' => self::ACTIVITY_ICONS['system'],
                'title' => 'New Equipment Equipped',
                'description' => 'Equipped the rare armor from shop',
                'timestamp' => now()->subDay(),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 11,
                'type' => 'system',
                'icon' => self::ACTIVITY_ICONS['system'],
                'title' => 'Boss HP Decreased',
                'description' => 'Multiple tasks completed - Boss HP dropped to 45%',
                'timestamp' => now()->subDays(2),
                'xp' => null,
                'gold' => null,
            ],
            [
                'id' => 12,
                'type' => 'combat',
                'icon' => self::ACTIVITY_ICONS['combat'],
                'title' => 'Task Completed',
                'description' => 'Completed comprehensive test coverage',
                'timestamp' => now()->subDays(2),
                'xp' => 70,
                'gold' => 35,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.activity-log');
    }
}
