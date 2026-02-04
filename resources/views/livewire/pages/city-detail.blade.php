<div class="pb-24">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600;700&display=swap');

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
            --status-success: #2ECC71;
            --status-warning: #F1C40F;
            --status-danger: #E74C3C;
            --status-info: #3498DB;
        }

        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(241, 196, 15, 0.2);
        }

        @keyframes boss-idle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .boss-idle { animation: boss-idle 2s ease-in-out infinite; }

        @keyframes commander-idle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .commander-idle { animation: commander-idle 2.5s ease-in-out infinite; }

        .character-defeated {
            filter: grayscale(100%);
            opacity: 0.6;
        }
        .character-silhouette {
            filter: brightness(0) saturate(100%);
            opacity: 0.4;
        }
    </style>

    <!-- Header with Back Button -->
    <header class="sticky top-0 z-40 bg-[#1a1a2e]/95 backdrop-blur border-b border-[#0f3460]">
        <div class="flex items-center gap-3 px-4 py-3">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="font-cinzel text-xl text-[#f1c40f]">{{ $city->name }}</h1>
                <p class="text-gray-500 text-xs">World > {{ $city->name }}</p>
            </div>
        </div>
    </header>

    <main class="p-4 space-y-4 max-w-7xl mx-auto">

        <!-- City Boss Progress -->
        <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-4">
            <div class="flex items-start gap-2 sm:gap-4">
                <!-- Boss Character SVG -->
                <div class="flex-shrink-0">
                    <svg width="60" height="75" viewBox="0 0 80 100" class="boss-idle sm:w-[80px] sm:h-[100px]">
                        <!-- Knight King Boss -->
                        <ellipse cx="40" cy="95" rx="25" ry="5" fill="#0f3460" opacity="0.5"/>
                        <path d="M20 45 Q10 70 25 90" fill="#e74c3c"/>
                        <path d="M60 45 Q70 70 55 90" fill="#e74c3c"/>
                        <rect x="22" y="45" width="36" height="40" rx="5" fill="#718096"/>
                        <rect x="28" y="50" width="24" height="10" fill="#4a5568"/>
                        <circle cx="40" cy="62" r="5" fill="#f1c40f"/>
                        <rect x="28" y="82" width="10" height="12" rx="2" fill="#4a5568"/>
                        <rect x="42" y="82" width="10" height="12" rx="2" fill="#4a5568"/>
                        <rect x="12" y="48" width="12" height="25" rx="4" fill="#718096"/>
                        <rect x="56" y="48" width="12" height="25" rx="4" fill="#718096"/>
                        <rect x="64" y="35" width="4" height="45" fill="#a0aec0"/>
                        <rect x="60" y="32" width="12" height="6" rx="2" fill="#f1c40f"/>
                        <path d="M64 30 L66 22 L68 30 Z" fill="#a0aec0"/>
                        <ellipse cx="15" cy="60" rx="10" ry="15" fill="#4a5568"/>
                        <ellipse cx="15" cy="60" rx="6" ry="10" fill="#f1c40f"/>
                        <circle cx="40" cy="30" r="20" fill="#ffd5b5"/>
                        <path d="M22 20 L28 5 L34 18 L40 0 L46 18 L52 5 L58 20" fill="#f1c40f" stroke="#d4a906" stroke-width="1"/>
                        <circle cx="40" cy="8" r="4" fill="#e74c3c"/>
                        <circle cx="28" cy="12" r="2" fill="#3498db"/>
                        <circle cx="52" cy="12" r="2" fill="#3498db"/>
                        <circle cx="33" cy="28" r="3" fill="#2d3748"/>
                        <circle cx="47" cy="28" r="3" fill="#2d3748"/>
                        <circle cx="34" cy="27" r="1" fill="white"/>
                        <circle cx="48" cy="27" r="1" fill="white"/>
                        <path d="M35 38 Q40 42 45 38" stroke="#a0522d" fill="none" stroke-width="2"/>
                    </svg>
                </div>
                <!-- Boss Info -->
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h2 class="font-cinzel text-lg text-[#f1c40f]">{{ $city->name }}</h2>
                            <p class="text-xs text-gray-400">City Boss</p>
                        </div>
                        <span class="font-bold text-lg sm:text-xl" style="color: {{ $this->getStatusColor($stats['overall_hp']) }}">{{ $stats['overall_hp'] }}%</span>
                    </div>
                    <div class="h-4 bg-[#0f3460] rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-gradient-to-r from-[#e74c3c] via-[#f1c40f] to-[#2ecc71] rounded-full transition-all duration-500" style="width: {{ $stats['overall_hp'] }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <p class="text-gray-400">{{ $stats['completed_flows'] }}/{{ $stats['total_flows'] }} Commanders Defeated</p>
                        <span style="color: {{ $this->getStatusColor($stats['overall_hp']) }}">
                            @if($stats['is_foggy'])
                                Fog of War
                            @elseif($stats['overall_hp'] >= 90)
                                Peaceful
                            @elseif($stats['overall_hp'] >= 60)
                                Stable
                            @elseif($stats['overall_hp'] >= 30)
                                In Battle
                            @else
                                Critical
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Panel -->
        <div class="grid grid-cols-3 gap-2 sm:gap-4">
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-2 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-[#3498db]">{{ $stats['total_flows'] }}</div>
                <div class="text-[10px] sm:text-xs text-gray-400">Flows</div>
            </div>
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-2 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-[#f1c40f]">{{ $stats['total_tasks'] }}</div>
                <div class="text-[10px] sm:text-xs text-gray-400">Tasks</div>
            </div>
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-2 sm:p-4 text-center">
                <div class="text-xl sm:text-2xl font-bold text-[#e74c3c]">{{ $stats['bugs_count'] }}</div>
                <div class="text-[10px] sm:text-xs text-gray-400">Bugs</div>
            </div>
        </div>

        <!-- Commanders List -->
        <div class="space-y-4">
            <h2 class="font-cinzel text-lg text-[#f1c40f] flex items-center gap-2">
                <span>Commanders ({{ count($flows) }})</span>
            </h2>

            @forelse($flows as $flow)
                <a href="#" class="block card-hover bg-[#16213e] border rounded-xl p-4
                    @if($flow['status'] === 'defeated') border-[#2ecc71] opacity-80
                    @elseif($flow['status'] === 'blocked') border-[#e74c3c]
                    @else border-[#f1c40f]
                    @endif">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <!-- Commander Character SVG -->
                            @if($flow['status'] === 'defeated')
                                <div class="relative flex-shrink-0">
                                    <svg width="50" height="65" viewBox="0 0 50 65" class="character-defeated">
                                        <ellipse cx="25" cy="62" rx="15" ry="3" fill="#0f3460" opacity="0.3"/>
                                        <rect x="15" y="32" width="20" height="25" rx="3" fill="#718096"/>
                                        <rect x="18" y="35" width="14" height="8" fill="#4a5568"/>
                                        <rect x="17" y="55" width="7" height="8" rx="2" fill="#4a5568"/>
                                        <rect x="26" y="55" width="7" height="8" rx="2" fill="#4a5568"/>
                                        <rect x="8" y="35" width="8" height="18" rx="3" fill="#718096"/>
                                        <rect x="34" y="35" width="8" height="18" rx="3" fill="#718096"/>
                                        <rect x="5" y="50" width="3" height="15" fill="#a0aec0" transform="rotate(-45 5 50)"/>
                                        <circle cx="25" cy="22" r="12" fill="#4a5568"/>
                                        <path d="M13 18 Q25 5 37 18" fill="#718096"/>
                                        <rect x="13" y="18" width="24" height="8" fill="#718096"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-2xl">💀</span>
                                    </div>
                                </div>
                            @elseif($flow['status'] === 'blocked')
                                <div class="relative flex-shrink-0">
                                    <svg width="50" height="65" viewBox="0 0 50 65" class="character-silhouette">
                                        <ellipse cx="25" cy="62" rx="15" ry="3" fill="#000"/>
                                        <path d="M12 30 L8 62 L42 62 L38 30 Z" fill="#000"/>
                                        <ellipse cx="25" cy="32" rx="14" ry="10" fill="#000"/>
                                        <circle cx="25" cy="18" r="13" fill="#000"/>
                                        <path d="M10 22 Q25 0 40 22 Q35 30 25 32 Q15 30 10 22 Z" fill="#000"/>
                                        <rect x="40" y="10" width="3" height="50" fill="#000"/>
                                        <circle cx="41.5" cy="8" r="5" fill="#000"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-2xl">🔒</span>
                                    </div>
                                </div>
                            @else
                                <svg width="50" height="65" viewBox="0 0 50 65" class="commander-idle flex-shrink-0">
                                    <ellipse cx="25" cy="62" rx="15" ry="3" fill="#0f3460" opacity="0.5"/>
                                    <path d="M15 35 L10 60 L40 60 L35 35 Z" fill="#9B59B6"/>
                                    <path d="M15 35 L12 60 L20 60 L18 40 Z" fill="#8E44AD"/>
                                    <ellipse cx="25" cy="35" rx="12" ry="8" fill="#9B59B6"/>
                                    <rect x="18" y="30" width="14" height="10" fill="#8E44AD"/>
                                    <rect x="38" y="15" width="3" height="45" fill="#8B4513"/>
                                    <circle cx="39.5" cy="12" r="6" fill="#3498DB"/>
                                    <circle cx="39.5" cy="12" r="3" fill="#85C1E9"/>
                                    <circle cx="25" cy="20" r="12" fill="#ffd5b5"/>
                                    <path d="M12 22 L25 -5 L38 22 Z" fill="#9B59B6"/>
                                    <ellipse cx="25" cy="22" rx="15" ry="4" fill="#8E44AD"/>
                                    <circle cx="25" cy="2" r="3" fill="#f1c40f"/>
                                    <circle cx="21" cy="18" r="2" fill="#2d3748"/>
                                    <circle cx="29" cy="18" r="2" fill="#2d3748"/>
                                    <path d="M22 25 Q25 27 28 25" stroke="#a0522d" fill="none" stroke-width="1.5"/>
                                    <circle cx="8" cy="45" r="4" fill="#f1c40f" opacity="0.6"/>
                                    <circle cx="10" cy="50" r="3" fill="#f1c40f" opacity="0.4"/>
                                </svg>
                            @endif
                            <div>
                                <h3 class="font-cinzel text-white">{{ $flow['name'] }}</h3>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-full
                                    @if($flow['status'] === 'defeated') bg-[#2ecc71]/20 text-[#2ecc71]
                                    @elseif($flow['status'] === 'blocked') bg-[#e74c3c]/20 text-[#e74c3c]
                                    @else bg-[#f1c40f]/20 text-[#f1c40f]
                                    @endif">
                                    @if($flow['status'] === 'defeated')
                                        Defeated
                                    @elseif($flow['status'] === 'blocked')
                                        Blocked
                                    @else
                                        In Battle
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold
                                @if($flow['overall_hp'] >= 90) text-[#2ecc71]
                                @elseif($flow['overall_hp'] >= 60) text-[#3498db]
                                @elseif($flow['overall_hp'] >= 30) text-[#f1c40f]
                                @else text-[#e74c3c]
                                @endif">{{ $flow['overall_hp'] }}%</div>
                            <div class="text-xs text-gray-400">Overall</div>
                        </div>
                    </div>

                    <!-- 6 HP Bars -->
                    <div class="space-y-2">
                        <!-- Design HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #E67E22">Design</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_design'] }}%; background: #E67E22"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_design'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_design'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_design'] }}%</span>
                        </div>
                        <!-- AC HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #3498DB">AC</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_ac'] }}%; background: #3498DB"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_ac'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_ac'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_ac'] }}%</span>
                        </div>
                        <!-- API HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #9B59B6">API</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_api'] }}%; background: #9B59B6"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_api'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_api'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_api'] }}%</span>
                        </div>
                        <!-- FE/App HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #1ABC9C">FE</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_fe'] }}%; background: #1ABC9C"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_fe'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_fe'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_fe'] }}%</span>
                        </div>
                        <!-- Testing HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #F1C40F">Test</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_testing'] }}%; background: #F1C40F"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_testing'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_testing'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_testing'] }}%</span>
                        </div>
                        <!-- UAT HP -->
                        <div class="flex items-center gap-2">
                            <span class="w-12 sm:w-16 text-[10px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span style="color: #2ECC71">UAT</span>
                            </span>
                            <div class="flex-1 h-2 bg-[#0f3460] rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $flow['hp_uat'] }}%; background: #2ECC71"></div>
                            </div>
                            <span class="w-10 text-xs text-right
                                @if($flow['hp_uat'] >= 100) text-[#2ecc71]
                                @elseif($flow['hp_uat'] >= 50) text-[#f1c40f]
                                @else text-gray-500
                                @endif">{{ $flow['hp_uat'] }}%</span>
                        </div>
                    </div>

                    <!-- Assignees -->
                    @if($flow['assignee'])
                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-400">
                            <span>Assignee:</span>
                            <span class="px-2 py-0.5 bg-[#0f3460] rounded">{{ $flow['assignee'] }}</span>
                        </div>
                    @endif
                </a>
            @empty
                <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-8 text-center">
                    <p class="text-gray-400">No commanders found in this city.</p>
                </div>
            @endforelse
        </div>

        <!-- Active Tasks Section -->
        @if(count($tasks) > 0)
            <div class="space-y-4">
                <h2 class="font-cinzel text-lg text-[#f1c40f] flex items-center gap-2">
                    <span>Active Tasks ({{ count($tasks) }})</span>
                </h2>

                <div class="bg-[#16213e] border border-[#0f3460] rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-[#0f3460]">
                                <tr>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-400">Task</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-400">Type</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-400">Flow</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-400">Status</th>
                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-[10px] sm:text-xs font-medium text-gray-400">Assignee</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#0f3460]">
                                @foreach($tasks as $task)
                                    <tr class="hover:bg-[#1a1a2e]">
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-white">{{ $task['title'] }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm">
                                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded text-[10px] sm:text-xs
                                                @if($task['type'] === 'UI') bg-[#E67E22]/20 text-[#E67E22]
                                                @elseif($task['type'] === 'API') bg-[#9B59B6]/20 text-[#9B59B6]
                                                @elseif($task['type'] === 'FE') bg-[#1ABC9C]/20 text-[#1ABC9C]
                                                @else bg-[#3498db]/20 text-[#3498db]
                                                @endif">
                                                {{ $task['type'] }}
                                            </span>
                                        </td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-400">{{ $task['flow_name'] }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm">
                                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded text-[10px] sm:text-xs
                                                @if($task['status'] === 'done') bg-[#2ecc71]/20 text-[#2ecc71]
                                                @elseif($task['status'] === 'doing') bg-[#f1c40f]/20 text-[#f1c40f]
                                                @else bg-gray-500/20 text-gray-400
                                                @endif">
                                                {{ ucfirst($task['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-400">{{ $task['assignee'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
