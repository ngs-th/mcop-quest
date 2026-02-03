<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Hero extends Component
{
    public array $hero = [];

    public array $stats = [];

    public array $skills = [];

    public array $inventory = [];

    public array $equipment = [];

    public array $activeTasks = [];

    public array $pendingTasks = [];

    public array $recentActivity = [];

    public function mount(): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login');

            return;
        }

        $this->loadHeroData();
    }

    public function render()
    {
        return view('livewire.pages.hero');
    }

    private function loadHeroData(): void
    {
        $user = Auth::user();

        $this->hero = [
            'name' => $user->name ?? 'Hero',
            'level' => 15,
            'class' => 'Warrior',
            'role' => 'Backend Dev',
            'xp' => 850,
            'xpMax' => 1000,
            'avatar' => null,
        ];

        $this->stats = [
            'kills' => 47,
            'gold' => 2450,
            'gems' => 15,
            'hp' => 100,
            'hpMax' => 100,
        ];

        $this->skills = [
            ['name' => 'API Design', 'level' => 8, 'icon' => '⚙️', 'color' => 'text-purple-500'],
            ['name' => 'Frontend', 'level' => 5, 'icon' => '💻', 'color' => 'text-teal-500'],
            ['name' => 'Testing', 'level' => 4, 'icon' => '🧪', 'color' => 'text-yellow-500'],
            ['name' => 'Database', 'level' => 7, 'icon' => '🗄️', 'color' => 'text-blue-500'],
        ];

        $this->equipment = [
            'head' => ['label' => 'Head', 'icon' => '🪖', 'item' => 'Iron Helm'],
            'lhand' => ['label' => 'L.Hand', 'icon' => '🛡️', 'item' => 'Wood Shield'],
            'body' => ['label' => 'Body', 'icon' => '🛡️', 'item' => 'Knight Armor'],
            'rhand' => ['label' => 'R.Hand', 'icon' => '🗡️', 'item' => 'Steel Sword'],
            'legs' => ['label' => 'Legs', 'icon' => '👖', 'item' => 'Iron Greaves'],
            'feet' => ['label' => 'Feet', 'icon' => '👢', 'item' => 'Leather Boots'],
        ];

        $this->inventory = [
            ['id' => 1, 'name' => 'Iron Helm', 'icon' => '🪖', 'type' => 'Armor', 'slot' => 'head', 'stats' => '+10 DEF', 'equipped' => true],
            ['id' => 2, 'name' => 'Knight Armor', 'icon' => '🛡️', 'type' => 'Armor', 'slot' => 'body', 'stats' => '+25 DEF', 'equipped' => true],
            ['id' => 3, 'name' => 'Steel Sword', 'icon' => '🗡️', 'type' => 'Weapon', 'slot' => 'rhand', 'stats' => '+15 ATK', 'equipped' => true],
            ['id' => 4, 'name' => 'Wood Shield', 'icon' => '🛡️', 'type' => 'Offhand', 'slot' => 'lhand', 'stats' => '+8 DEF', 'equipped' => true],
            ['id' => 5, 'name' => 'Iron Greaves', 'icon' => '👖', 'type' => 'Armor', 'slot' => 'legs', 'stats' => '+12 DEF', 'equipped' => true],
            ['id' => 6, 'name' => 'Leather Boots', 'icon' => '👢', 'type' => 'Armor', 'slot' => 'feet', 'stats' => '+5 DEF, +2 SPD', 'equipped' => true],
            ['id' => 7, 'name' => 'Bronze Helm', 'icon' => '⛑️', 'type' => 'Armor', 'slot' => 'head', 'stats' => '+5 DEF', 'equipped' => false],
            ['id' => 8, 'name' => 'Rusty Sword', 'icon' => '⚔️', 'type' => 'Weapon', 'slot' => 'rhand', 'stats' => '+8 ATK', 'equipped' => false],
            ['id' => 9, 'name' => 'Cloth Robe', 'icon' => '👕', 'type' => 'Armor', 'slot' => 'body', 'stats' => '+3 DEF, +5 MANA', 'equipped' => false],
            ['id' => 10, 'name' => 'HP Potion', 'icon' => '🧪', 'type' => 'Consumable', 'slot' => '-', 'stats' => 'Restore 50 HP', 'equipped' => false],
            ['id' => 11, 'name' => 'Mana Potion', 'icon' => '💧', 'type' => 'Consumable', 'slot' => '-', 'stats' => 'Restore 30 MP', 'equipped' => false],
            ['id' => 12, 'name' => 'Gold Ring', 'icon' => '💍', 'type' => 'Accessory', 'slot' => 'accessory', 'stats' => '+10% Gold', 'equipped' => false],
        ];

        $this->activeTasks = [
            ['icon' => '⚙️', 'color' => 'text-purple-500', 'name' => 'JWT Token refresh mechanism', 'flow' => 'Login', 'status' => 'Doing'],
            ['icon' => '⚙️', 'color' => 'text-purple-500', 'name' => 'Password reset API endpoint', 'flow' => 'Password Reset', 'status' => 'Doing'],
            ['icon' => '💻', 'color' => 'text-teal-500', 'name' => 'Connect to auth API', 'flow' => 'Login', 'status' => 'Doing'],
        ];

        $this->pendingTasks = [
            ['icon' => '⚙️', 'color' => 'text-purple-500', 'name' => 'Email verification API', 'flow' => 'Registration', 'status' => 'Pending'],
            ['icon' => '⚙️', 'color' => 'text-purple-500', 'name' => 'User profile CRUD', 'flow' => 'Profile Management', 'status' => 'Pending'],
            ['icon' => '⚙️', 'color' => 'text-purple-500', 'name' => 'Password change endpoint', 'flow' => 'Security', 'status' => 'Pending'],
            ['icon' => '💻', 'color' => 'text-teal-500', 'name' => 'Profile page integration', 'flow' => 'Profile Management', 'status' => 'Pending'],
            ['icon' => '🧪', 'color' => 'text-yellow-500', 'name' => 'Unit tests for auth module', 'flow' => 'Login', 'status' => 'Pending'],
        ];

        $this->recentActivity = [
            ['icon' => '⚔️', 'title' => 'Defeated Minion: POST /api/auth/login', 'meta' => '2 hours ago • +50 Gold, +100 XP', 'highlight' => 'text-purple-500'],
            ['icon' => '🎉', 'title' => 'Level Up! Level 15', 'meta' => 'Yesterday • New skills unlocked', 'highlight' => 'text-yellow-500'],
            ['icon' => '💀', 'title' => 'Commander Defeated: Flow: Registration', 'meta' => '2 days ago • +5 Gems', 'highlight' => 'text-green-500'],
        ];
    }
}
