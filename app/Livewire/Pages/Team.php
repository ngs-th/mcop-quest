<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Team extends Component
{
    public string $currentTeamId = 'mcop';

    public function render()
    {
        return view('livewire.pages.team', [
            'currentTeam' => $this->getCurrentTeam(),
            'teams' => $this->getAvailableTeams(),
        ]);
    }

    public function switchTeam(string $teamId): void
    {
        $this->currentTeamId = $teamId;
    }

    public function getCurrentTeam(): array
    {
        $teams = $this->getAllTeamsData();

        return $teams[$this->currentTeamId] ?? $teams['mcop'];
    }

    public function getAvailableTeams(): array
    {
        return [
            ['id' => 'mcop', 'name' => 'MCOP Guild', 'icon' => '🏰'],
            ['id' => 'phoenix', 'name' => 'Phoenix Squad', 'icon' => '🔥'],
            ['id' => 'dragon', 'name' => 'Dragon Team', 'icon' => '🐉'],
        ];
    }

    public function getTotalActiveTasks(): int
    {
        $team = $this->getCurrentTeam();

        return array_reduce($team['members'], fn ($sum, $m) => $sum + ($m['tasks']['doing'] ?? 0), 0);
    }

    private function getAllTeamsData(): array
    {
        return [
            'mcop' => [
                'id' => 'mcop',
                'name' => 'MCOP Guild',
                'icon' => '🏰',
                'progress' => 54,
                'tasksDone' => 127,
                'commanders' => 5,
                'members' => [
                    [
                        'id' => 'ken',
                        'name' => 'Ken',
                        'icon' => '⚔️',
                        'color' => '#9B59B6',
                        'level' => 15,
                        'xp' => 850,
                        'xpMax' => 1000,
                        'kills' => 47,
                        'gold' => 2450,
                        'class' => '⚔️ Warrior (Backend Dev)',
                        'tasks' => ['doing' => 3, 'pending' => 2, 'done' => 15],
                        'activeTasks' => [
                            ['name' => 'JWT Token refresh mechanism', 'type' => 'API'],
                            ['name' => 'Database migration scripts', 'type' => 'API'],
                            ['name' => 'Redis cache implementation', 'type' => 'API'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🪖', 'name' => 'Iron Helm'],
                            'body' => ['icon' => '🛡️', 'name' => 'Knight Armor'],
                            'weapon' => ['icon' => '⚔️', 'name' => 'Steel Sword'],
                            'offhand' => ['icon' => '🛡️', 'name' => 'Wood Shield'],
                            'legs' => ['icon' => '🦿', 'name' => 'Iron Greaves'],
                            'feet' => ['icon' => '👢', 'name' => 'Leather Boots'],
                        ],
                    ],
                    [
                        'id' => 'may',
                        'name' => 'May',
                        'icon' => '🧙',
                        'color' => '#1ABC9C',
                        'level' => 12,
                        'xp' => 600,
                        'xpMax' => 800,
                        'kills' => 38,
                        'gold' => 1890,
                        'class' => '🧙 Mage (Frontend Dev)',
                        'tasks' => ['doing' => 2, 'pending' => 3, 'done' => 12],
                        'activeTasks' => [
                            ['name' => 'Connect to auth API', 'type' => 'FE'],
                            ['name' => 'Login form validation', 'type' => 'FE'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🎩', 'name' => 'Wizard Hat'],
                            'body' => ['icon' => '🧥', 'name' => 'Mystic Robe'],
                            'weapon' => ['icon' => '🪄', 'name' => 'Magic Staff'],
                            'offhand' => ['icon' => '📖', 'name' => 'Spell Book'],
                            'legs' => ['icon' => '👖', 'name' => 'Cloth Pants'],
                            'feet' => ['icon' => '🥿', 'name' => 'Soft Shoes'],
                        ],
                    ],
                    [
                        'id' => 'ton',
                        'name' => 'Ton',
                        'icon' => '🔨',
                        'color' => '#E67E22',
                        'level' => 10,
                        'xp' => 450,
                        'xpMax' => 600,
                        'kills' => 24,
                        'gold' => 3200,
                        'class' => '🔨 Blacksmith (UX Designer)',
                        'tasks' => ['doing' => 1, 'pending' => 4, 'done' => 8],
                        'activeTasks' => [
                            ['name' => 'Wireframe Password Reset', 'type' => 'UI'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🪖', 'name' => 'Bandana'],
                            'body' => ['icon' => '👕', 'name' => 'Work Apron'],
                            'weapon' => ['icon' => '🔨', 'name' => 'Forge Hammer'],
                            'offhand' => ['icon' => '🧤', 'name' => 'Heat Gloves'],
                            'legs' => ['icon' => '👖', 'name' => 'Thick Pants'],
                            'feet' => ['icon' => '👢', 'name' => 'Steel Boots'],
                        ],
                    ],
                    [
                        'id' => 'sarah',
                        'name' => 'Sarah',
                        'icon' => '🔍',
                        'color' => '#3498DB',
                        'level' => 14,
                        'xp' => 700,
                        'xpMax' => 900,
                        'kills' => 18,
                        'gold' => 1650,
                        'class' => '🔍 Scout (Business Analyst)',
                        'tasks' => ['doing' => 2, 'pending' => 1, 'done' => 20],
                        'activeTasks' => [
                            ['name' => 'AC for Payment Gateway', 'type' => 'AC'],
                            ['name' => 'User story refinement', 'type' => 'AC'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🎭', 'name' => 'Scout Hood'],
                            'body' => ['icon' => '🧥', 'name' => 'Travel Cloak'],
                            'weapon' => ['icon' => '🔍', 'name' => 'Magnifier'],
                            'offhand' => ['icon' => '📜', 'name' => 'Scroll Case'],
                            'legs' => ['icon' => '👖', 'name' => 'Light Pants'],
                            'feet' => ['icon' => '👟', 'name' => 'Swift Boots'],
                        ],
                    ],
                    [
                        'id' => 'nat',
                        'name' => 'Nat',
                        'icon' => '💊',
                        'color' => '#F1C40F',
                        'level' => 11,
                        'xp' => 550,
                        'xpMax' => 700,
                        'kills' => 32,
                        'gold' => 1420,
                        'class' => '💊 Healer (QA Tester)',
                        'tasks' => ['doing' => 4, 'pending' => 2, 'done' => 25],
                        'activeTasks' => [
                            ['name' => 'Registration flow regression', 'type' => 'Testing'],
                            ['name' => 'Login edge cases', 'type' => 'Testing'],
                            ['name' => 'Password reset E2E', 'type' => 'Testing'],
                            ['name' => 'API response validation', 'type' => 'Testing'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '⛑️', 'name' => 'Nurse Cap'],
                            'body' => ['icon' => '🥼', 'name' => 'White Robe'],
                            'weapon' => ['icon' => '💉', 'name' => 'Healing Syringe'],
                            'offhand' => ['icon' => '🧪', 'name' => 'Potion Bag'],
                            'legs' => ['icon' => '👖', 'name' => 'Clean Pants'],
                            'feet' => ['icon' => '👟', 'name' => 'Soft Shoes'],
                        ],
                    ],
                    [
                        'id' => 'om',
                        'name' => 'Om',
                        'icon' => '👑',
                        'color' => '#f1c40f',
                        'level' => 20,
                        'xp' => 900,
                        'xpMax' => 1000,
                        'kills' => 999,
                        'gold' => 9999,
                        'class' => '👑 Guild Master (PM)',
                        'tasks' => ['doing' => 0, 'pending' => 5, 'done' => 50],
                        'activeTasks' => [],
                        'equipment' => [
                            'head' => ['icon' => '👑', 'name' => 'Royal Crown'],
                            'body' => ['icon' => '👘', 'name' => 'Royal Robe'],
                            'weapon' => ['icon' => '🏆', 'name' => 'Royal Scepter'],
                            'offhand' => ['icon' => '📋', 'name' => 'Project Scroll'],
                            'legs' => ['icon' => '👖', 'name' => 'Royal Pants'],
                            'feet' => ['icon' => '👢', 'name' => 'Golden Boots'],
                        ],
                    ],
                ],
            ],
            'phoenix' => [
                'id' => 'phoenix',
                'name' => 'Phoenix Squad',
                'icon' => '🔥',
                'progress' => 72,
                'tasksDone' => 85,
                'commanders' => 3,
                'members' => [
                    [
                        'id' => 'anna',
                        'name' => 'Anna',
                        'icon' => '🔥',
                        'color' => '#E74C3C',
                        'level' => 18,
                        'xp' => 800,
                        'xpMax' => 1000,
                        'kills' => 62,
                        'gold' => 3100,
                        'class' => '🔥 Fire Mage (Tech Lead)',
                        'tasks' => ['doing' => 2, 'pending' => 1, 'done' => 30],
                        'activeTasks' => [
                            ['name' => 'Architecture review', 'type' => 'AC'],
                            ['name' => 'Code review backlog', 'type' => 'API'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🔥', 'name' => 'Flame Crown'],
                            'body' => ['icon' => '🧥', 'name' => 'Fire Robe'],
                            'weapon' => ['icon' => '🪄', 'name' => 'Fire Staff'],
                            'offhand' => ['icon' => '📕', 'name' => 'Spell Tome'],
                            'legs' => ['icon' => '👖', 'name' => 'Ash Pants'],
                            'feet' => ['icon' => '👢', 'name' => 'Ember Boots'],
                        ],
                    ],
                    [
                        'id' => 'bob',
                        'name' => 'Bob',
                        'icon' => '🛡️',
                        'color' => '#95A5A6',
                        'level' => 14,
                        'xp' => 650,
                        'xpMax' => 900,
                        'kills' => 35,
                        'gold' => 2200,
                        'class' => '🛡️ Tank (DevOps)',
                        'tasks' => ['doing' => 1, 'pending' => 3, 'done' => 18],
                        'activeTasks' => [
                            ['name' => 'CI/CD pipeline fix', 'type' => 'API'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🪖', 'name' => 'Steel Helm'],
                            'body' => ['icon' => '🛡️', 'name' => 'Plate Armor'],
                            'weapon' => ['icon' => '🛡️', 'name' => 'Tower Shield'],
                            'offhand' => ['icon' => '⚔️', 'name' => 'Short Sword'],
                            'legs' => ['icon' => '🦿', 'name' => 'Plate Legs'],
                            'feet' => ['icon' => '👢', 'name' => 'Heavy Boots'],
                        ],
                    ],
                    [
                        'id' => 'clara',
                        'name' => 'Clara',
                        'icon' => '🎯',
                        'color' => '#9B59B6',
                        'level' => 13,
                        'xp' => 580,
                        'xpMax' => 850,
                        'kills' => 28,
                        'gold' => 1950,
                        'class' => '🎯 Archer (Frontend)',
                        'tasks' => ['doing' => 3, 'pending' => 2, 'done' => 22],
                        'activeTasks' => [
                            ['name' => 'Dashboard charts', 'type' => 'FE'],
                            ['name' => 'Mobile responsive', 'type' => 'FE'],
                            ['name' => 'Animation polish', 'type' => 'UI'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🎀', 'name' => 'Hunter Hood'],
                            'body' => ['icon' => '🧥', 'name' => 'Leather Vest'],
                            'weapon' => ['icon' => '🏹', 'name' => 'Long Bow'],
                            'offhand' => ['icon' => '🎯', 'name' => 'Quiver'],
                            'legs' => ['icon' => '👖', 'name' => 'Scout Pants'],
                            'feet' => ['icon' => '👟', 'name' => 'Silent Boots'],
                        ],
                    ],
                ],
            ],
            'dragon' => [
                'id' => 'dragon',
                'name' => 'Dragon Team',
                'icon' => '🐉',
                'progress' => 45,
                'tasksDone' => 63,
                'commanders' => 4,
                'members' => [
                    [
                        'id' => 'drake',
                        'name' => 'Drake',
                        'icon' => '🐉',
                        'color' => '#27AE60',
                        'level' => 16,
                        'xp' => 720,
                        'xpMax' => 950,
                        'kills' => 55,
                        'gold' => 2800,
                        'class' => '🐉 Dragon Knight (Full Stack)',
                        'tasks' => ['doing' => 2, 'pending' => 4, 'done' => 28],
                        'activeTasks' => [
                            ['name' => 'GraphQL API', 'type' => 'API'],
                            ['name' => 'React Query setup', 'type' => 'FE'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '🐉', 'name' => 'Dragon Helm'],
                            'body' => ['icon' => '🛡️', 'name' => 'Scale Mail'],
                            'weapon' => ['icon' => '⚔️', 'name' => 'Dragon Blade'],
                            'offhand' => ['icon' => '🛡️', 'name' => 'Wing Shield'],
                            'legs' => ['icon' => '🦿', 'name' => 'Scale Legs'],
                            'feet' => ['icon' => '👢', 'name' => 'Claw Boots'],
                        ],
                    ],
                    [
                        'id' => 'ember',
                        'name' => 'Ember',
                        'icon' => '✨',
                        'color' => '#F39C12',
                        'level' => 12,
                        'xp' => 520,
                        'xpMax' => 750,
                        'kills' => 22,
                        'gold' => 1600,
                        'class' => '✨ Enchanter (UX/UI)',
                        'tasks' => ['doing' => 1, 'pending' => 2, 'done' => 15],
                        'activeTasks' => [
                            ['name' => 'Design system tokens', 'type' => 'UI'],
                        ],
                        'equipment' => [
                            'head' => ['icon' => '✨', 'name' => 'Starlight Tiara'],
                            'body' => ['icon' => '🧥', 'name' => 'Shimmer Dress'],
                            'weapon' => ['icon' => '🪄', 'name' => 'Star Wand'],
                            'offhand' => ['icon' => '📖', 'name' => 'Design Book'],
                            'legs' => ['icon' => '👖', 'name' => 'Silk Pants'],
                            'feet' => ['icon' => '👠', 'name' => 'Glass Slippers'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
