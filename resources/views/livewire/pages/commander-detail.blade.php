<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap');

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }

        :root {
            --rpg-bg: #1a1a2e;
            --rpg-card: #16213e;
            --rpg-border: #0f3460;
            --rpg-gold: #f1c40f;
            --rpg-gold-dark: #d4a906;
            --hp-design: #E67E22;
            --hp-ac: #3498DB;
            --hp-api: #9B59B6;
            --hp-fe: #1ABC9C;
            --hp-testing: #F1C40F;
            --hp-uat: #2ECC71;
        }

        .minion-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .minion-card:hover {
            transform: translateX(4px);
        }
    </style>

    <div class="min-h-screen pb-20 font-inter" style="background: var(--rpg-bg);">
        <!-- Header with Back Button -->
        <header class="sticky top-0 z-40 border-b backdrop-blur" style="background: rgba(26, 26, 46, 0.95); border-color: var(--rpg-border);">
            <div class="flex items-center gap-3 px-4 py-3">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-xl font-cinzel" style="color: var(--rpg-gold);">⚔️ {{ $flow->name }}</h1>
                    <p class="text-[10px] sm:text-xs text-gray-500 truncate">
                        🗺️ World > 🏰 {{ $flow->system->name ?? 'Unknown System' }} > ⚔️ {{ $flow->name }}
                    </p>
                </div>
                <div class="flex items-center gap-1 text-xs text-gray-400">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span>Live</span>
                </div>
            </div>
        </header>

        <main class="p-4 space-y-4">
            <!-- Commander Summary Card -->
            <div class="rounded-xl p-4 border" style="background: var(--rpg-card); border-color: var(--rpg-gold);">
                <div class="flex items-center gap-2 sm:gap-4 mb-4">
                    <div class="text-4xl sm:text-5xl">⚔️</div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg sm:text-xl text-white font-cinzel truncate">{{ $flow->name }}</h2>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs"
                              style="background: rgba(241, 196, 15, 0.2); color: var(--rpg-gold);">
                            ⚔️ {{ $this->getStatusLabel() }}
                        </span>
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div class="text-2xl sm:text-3xl font-bold" style="color: var(--rpg-gold);">{{ $this->getOverallProgress() }}%</div>
                        <div class="text-[10px] sm:text-xs text-gray-400">Overall</div>
                    </div>
                </div>

                <!-- 6 HP Bars -->
                <div class="space-y-3">
                    <!-- Design HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-design)">📐</span>
                                <span>Design</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_design >= 100 ? 'text-green-400' : ($flow->hp_design >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_design }}% {{ $flow->hp_design >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_design }}%; background: var(--hp-design);"></div>
                        </div>
                    </div>

                    <!-- AC HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-ac)">📋</span>
                                <span>AC (Acceptance Criteria)</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_ac >= 100 ? 'text-green-400' : ($flow->hp_ac >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_ac }}% {{ $flow->hp_ac >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_ac }}%; background: var(--hp-ac);"></div>
                        </div>
                    </div>

                    <!-- API HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-api)">⚙️</span>
                                <span>API</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_api >= 100 ? 'text-green-400' : ($flow->hp_api >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_api }}% {{ $flow->hp_api >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_api }}%; background: var(--hp-api);"></div>
                        </div>
                    </div>

                    <!-- FE/App HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-fe)">💻</span>
                                <span>FE/App</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_fe >= 100 ? 'text-green-400' : ($flow->hp_fe >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_fe }}% {{ $flow->hp_fe >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_fe }}%; background: var(--hp-fe);"></div>
                        </div>
                    </div>

                    <!-- Testing HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-testing)">🧪</span>
                                <span>Testing</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_testing >= 100 ? 'text-green-400' : ($flow->hp_testing >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_testing }}% {{ $flow->hp_testing >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_testing }}%; background: var(--hp-testing);"></div>
                        </div>
                    </div>

                    <!-- UAT HP -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm flex items-center gap-2 text-white">
                                <span style="color: var(--hp-uat)">✅</span>
                                <span>UAT</span>
                            </span>
                            <span class="text-sm font-medium {{ $flow->hp_uat >= 100 ? 'text-green-400' : ($flow->hp_uat >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                {{ $flow->hp_uat }}% {{ $flow->hp_uat >= 100 ? '✓' : '' }}
                            </span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background: var(--rpg-border);">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $flow->hp_uat }}%; background: var(--hp-uat);"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minions (Tasks) Section -->
            <div class="space-y-4">
                <h2 class="text-lg font-cinzel flex items-center gap-2" style="color: var(--rpg-gold);">
                    <span>👾</span>
                    <span>Minions ({{ count($tasks) }} Tasks)</span>
                </h2>

                <!-- Task Type Summary -->
                <div class="flex gap-2 overflow-x-auto pb-2">
                    @foreach($this->getTaskCountsByType() as $type => $counts)
                        @if($counts['total'] > 0)
                            <div class="px-2 sm:px-3 py-2 rounded-lg whitespace-nowrap text-xs sm:text-sm border"
                                 style="background: var(--rpg-card); border-color: var(--rpg-border); color: var(--hp-{{ strtolower($type) }});">
                                {{ $this->getTypeIcon($type) }} {{ $type }} ({{ $counts['done'] }}/{{ $counts['total'] }})
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Tasks by Type -->
                <div class="space-y-2">
                    @foreach(['UI', 'API', 'FE'] as $type)
                        @php
                            $typeTasks = $this->getTasksByType($type);
                            $typeColor = match($type) {
                                'UI' => 'var(--hp-design)',
                                'API' => 'var(--hp-api)',
                                'FE' => 'var(--hp-fe)',
                                default => '#95A5A6'
                            };
                        @endphp

                        @if(count($typeTasks) > 0)
                            <div class="text-xs text-gray-500 uppercase tracking-wider mt-4 mb-2 flex items-center gap-2">
                                <span style="color: {{ $typeColor }}">{{ $this->getTypeIcon($type) }}</span>
                                {{ $type }} Tasks ({{ collect($typeTasks)->where('status', 'done')->count() }}/{{ count($typeTasks) }} Done)
                            </div>

                            @foreach($typeTasks as $task)
                                @php
                                    $borderColor = match($task['status']) {
                                        'done' => '#22c55e',
                                        'doing' => '#eab308',
                                        default => '#4b5563'
                                    };
                                    $isDone = $task['status'] === 'done';
                                @endphp

                                <div class="minion-card rounded-r-lg p-3 flex items-center gap-3 border-l-4"
                                     style="background: var(--rpg-card); border-left-color: {{ $borderColor }}; {{ $isDone ? 'opacity: 0.7;' : '' }}">
                                    <span class="text-xl">{{ $this->getTypeIcon($type) }}</span>
                                    <div class="flex-1">
                                        <p class="text-sm {{ $isDone ? 'text-gray-400 line-through' : 'text-white' }}">
                                            {{ $task['title'] }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-1.5 py-0.5 text-xs rounded"
                                                  style="background: {{ $typeColor }}33; color: {{ $typeColor }};">
                                                {{ $type }}
                                            </span>
                                            @if($task['assignee'])
                                                <span class="text-xs text-gray-500">{{ $task['assignee'] }}</span>
                                            @endif
                                            @if($isDone)
                                                <span class="text-xs text-green-400">✓ Done</span>
                                            @elseif($task['status'] === 'doing')
                                                <span class="px-1.5 py-0.5 text-xs rounded bg-yellow-400/20 text-yellow-400">Doing</span>
                                            @else
                                                <span class="px-1.5 py-0.5 text-xs rounded bg-gray-600/20 text-gray-400">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($task['url'])
                                        <a href="{{ $task['url'] }}" target="_blank" class="text-xs hover:underline" style="color: var(--rpg-gold);">
                                            Link
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Team Assigned -->
            @if(count($team) > 0)
                <div class="rounded-xl p-4 mt-6 border" style="background: var(--rpg-card); border-color: var(--rpg-border);">
                    <h3 class="text-sm font-cinzel mb-3" style="color: var(--rpg-gold);">Team Assigned</h3>
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        @foreach($team as $member)
                            <div class="flex items-center gap-2 rounded-lg px-3 py-2"
                                 style="background: rgba(15, 52, 96, 0.5);">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm text-white"
                                      style="background: {{ $member['color'] }}33; color: {{ $member['color'] }};">
                                    {{ $member['initial'] }}
                                </span>
                                <div>
                                    <p class="text-sm text-white">{{ $member['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $member['type_icon'] }} {{ $member['type'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- System Info -->
            @if($flow->system)
                <div class="rounded-xl p-4 border" style="background: var(--rpg-card); border-color: var(--rpg-border);">
                    <h3 class="text-sm font-cinzel mb-2" style="color: var(--rpg-gold);">System Information</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🏰</span>
                        <div>
                            <p class="text-sm text-white">{{ $flow->system->name }}</p>
                            @if($flow->system->description)
                                <p class="text-xs text-gray-500">{{ $flow->system->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </main>

        <!-- Bottom Tab Bar -->
        <nav class="fixed bottom-0 left-0 right-0 bg-[#16213e] border-t border-[#0f3460] z-50" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
            <div class="flex justify-around">
                <a href="{{ route('hero') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x2694;&#xFE0F;</div>
                    <div class="text-[10px] sm:text-xs mt-1" style="font-family: 'Cinzel', serif;">Hero</div>
                </a>
                <a href="{{ route('team') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x1F465;</div>
                    <div class="text-[10px] sm:text-xs mt-1" style="font-family: 'Cinzel', serif;">Team</div>
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x1F5FA;&#xFE0F;</div>
                    <div class="text-[10px] sm:text-xs mt-1" style="font-family: 'Cinzel', serif;">World</div>
                </a>
                <a href="{{ route('shop') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x1F6D2;</div>
                    <div class="text-[10px] sm:text-xs mt-1" style="font-family: 'Cinzel', serif;">Shop</div>
                </a>
            </div>
        </nav>
    </div>
</div>
