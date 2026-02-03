<div class="min-h-screen bg-[#1a1a2e] text-white pb-20">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600;700&display=swap');

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }

        .timeline-line {
            background: linear-gradient(to bottom, #f1c40f 0%, #0f3460 100%);
        }

        .log-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .log-card:hover {
            transform: translateX(4px);
            box-shadow: -4px 0 15px rgba(241, 196, 15, 0.1);
        }

        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(241, 196, 15, 0.4); }
            50% { box-shadow: 0 0 0 4px rgba(241, 196, 15, 0); }
        }

        .animate-pulse-gold {
            animation: pulse-gold 2s infinite;
        }
    </style>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-[#1a1a2e]/95 backdrop-blur border-b border-[#0f3460]">
        <div class="flex items-center justify-between px-4 py-3">
            <div>
                <h1 class="font-cinzel text-xl text-[#f1c40f]">📜 Activity Log</h1>
                <p class="text-gray-500 text-xs">Project Timeline & Events</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-xs text-gray-400">Live</span>
            </div>
        </div>
    </header>

    {{-- Filter Section --}}
    <div class="sticky top-14 z-30 bg-[#1a1a2e]/95 backdrop-blur border-b border-[#0f3460] px-4 py-3">
        <div class="flex gap-2 overflow-x-auto pb-2">
            <flux:button
                wire:click="filterByType('all')"
                :variant="$filter === 'all' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'all' ? 'bg-[#f1c40f] text-[#1a1a2e]' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                All
            </flux:button>
            <flux:button
                wire:click="filterByType('combat')"
                :variant="$filter === 'combat' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'combat' ? 'bg-blue-500 text-white' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                ⚔️ Combat
            </flux:button>
            <flux:button
                wire:click="filterByType('exploration')"
                :variant="$filter === 'exploration' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'exploration' ? 'bg-amber-500 text-white' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                🗺️ Exploration
            </flux:button>
            <flux:button
                wire:click="filterByType('social')"
                :variant="$filter === 'social' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'social' ? 'bg-purple-500 text-white' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                👥 Social
            </flux:button>
            <flux:button
                wire:click="filterByType('achievement')"
                :variant="$filter === 'achievement' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'achievement' ? 'bg-green-500 text-white' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                🏆 Achievement
            </flux:button>
            <flux:button
                wire:click="filterByType('system')"
                :variant="$filter === 'system' ? 'primary' : 'ghost'"
                class="whitespace-nowrap {{ $filter === 'system' ? 'bg-gray-500 text-white' : 'bg-[#16213e] border border-[#0f3460] text-gray-400' }}"
            >
                ⚙️ System
            </flux:button>
        </div>
        <div class="flex items-center gap-2 mt-2">
            <span class="text-xs text-gray-500">{{ count($activities) }} events</span>
        </div>
    </div>

    {{-- Timeline --}}
    <main class="p-4">
        <div class="relative">
            {{-- Timeline Line --}}
            <div class="absolute left-4 top-0 bottom-0 w-0.5 timeline-line"></div>

            {{-- Activity Items --}}
            <div class="space-y-4">
                @forelse($activities as $activity)
                    <div class="log-card relative pl-12">
                        {{-- Timeline Dot --}}
                        <div class="absolute left-2 top-4 w-5 h-5 rounded-full border-2 border-[#1a1a2e] flex items-center justify-center
                            {{ match($activity['type']) {
                                'combat' => 'bg-red-500',
                                'exploration' => 'bg-amber-500',
                                'social' => 'bg-purple-500',
                                'achievement' => 'bg-green-500',
                                'system' => 'bg-gray-500',
                                default => 'bg-gray-500'
                            } }}">
                            <span class="text-xs">
                                {{ match($activity['type']) {
                                    'combat' => '⚔️',
                                    'exploration' => '🗺️',
                                    'social' => '👥',
                                    'achievement' => '🏆',
                                    'system' => '⚙️',
                                    default => '•'
                                } }}
                            </span>
                        </div>

                        {{-- Log Card --}}
                        <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-4
                            {{ match($activity['type']) {
                                'combat' => 'border-red-500/30',
                                'exploration' => 'border-amber-500/30',
                                'social' => 'border-purple-500/30',
                                'achievement' => 'border-green-500/30',
                                'system' => 'border-gray-500/30',
                                default => ''
                            } }}">
                            {{-- Header --}}
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">{{ $activity['icon'] }}</span>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['description'] }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $activity['timestamp']->diffForHumans() }}</span>
                            </div>

                            {{-- Rewards --}}
                            @if($activity['xp'] || $activity['gold'])
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @if($activity['xp'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs bg-yellow-500/20 text-yellow-400">
                                            <span>⭐</span>
                                            <span>+{{ $activity['xp'] }} XP</span>
                                        </span>
                                    @endif
                                    @if($activity['gold'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs bg-[#f1c40f]/20 text-[#f1c40f]">
                                            <span>🪙</span>
                                            <span>+{{ $activity['gold'] }} Gold</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">📭</div>
                        <p class="text-gray-500">No activities found</p>
                        <p class="text-xs text-gray-600 mt-1">Try adjusting your filters</p>
                    </div>
                @endforelse
            </div>

            {{-- Load More --}}
            @if(count($activities) > 0)
                <div class="text-center mt-6">
                    <flux:button
                        wire:click="loadMore"
                        variant="ghost"
                        class="bg-[#16213e] border border-[#0f3460] text-gray-400 hover:text-[#f1c40f] hover:border-[#f1c40f]"
                    >
                        Load More
                    </flux:button>
                </div>
            @endif
        </div>
    </main>
</div>
