<div x-data="teamData()" x-init="init()">
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
            --status-success: #2ECC71;
            --status-warning: #F1C40F;
            --status-danger: #E74C3C;
            --status-info: #3498DB;
        }

        .tab-active { border-bottom: 3px solid #f1c40f; }

        @keyframes idle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-2px); }
        }
        @keyframes monster-idle {
            0%, 100% { transform: translateY(0) scaleX(-1); }
            50% { transform: translateY(-3px) scaleX(-1); }
        }
        @keyframes attack-slash {
            0%, 100% { opacity: 0; transform: rotate(-45deg) scale(0.5); }
            50% { opacity: 1; transform: rotate(-45deg) scale(1); }
        }
        @keyframes damage-float {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }

        .animate-idle { animation: idle 2s ease-in-out infinite; }
        .animate-monster { animation: monster-idle 1.5s ease-in-out infinite; }
        .animate-slash { animation: attack-slash 0.8s ease-in-out infinite; }
        .animate-damage { animation: damage-float 1s ease-out infinite; }

        .avatar-clickable {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .avatar-clickable:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(241, 196, 15, 0.5);
        }

        .battle-scene {
            background: linear-gradient(to bottom, #1a1a2e 0%, #2d1f3d 50%, #1a1a2e 100%);
        }
    </style>

    <div class="bg-[#1a1a2e] text-white font-inter min-h-screen pb-24">
        <!-- Header with Team Selector -->
        <header class="sticky top-0 z-40 bg-[#1a1a2e]/95 backdrop-blur border-b border-[#0f3460]">
            <div class="flex items-center justify-between px-4 py-3">
                <div>
                    <h1 class="font-cinzel text-xl text-[#f1c40f]">Team View</h1>
                    <p class="text-gray-500 text-xs">Viewing: <span x-text="currentTeam.name" class="text-[#f1c40f]"></span></p>
                </div>

                <!-- Team Selector Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 bg-[#16213e] border border-[#0f3460] rounded-lg px-3 py-2 text-sm">
                        <span>🏰</span>
                        <span x-text="currentTeam.name" class="text-[#f1c40f]"></span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-[#16213e] border border-[#0f3460] rounded-lg shadow-xl z-50">
                        <template x-for="team in availableTeams" :key="team.id">
                            <button @click="switchTeam(team.id); open = false"
                                    class="w-full px-4 py-2 text-left text-sm hover:bg-[#0f3460]/50 flex items-center gap-2"
                                    :class="currentTeam.id === team.id ? 'text-[#f1c40f]' : 'text-gray-300'">
                                <span x-text="team.icon"></span>
                                <span x-text="team.name"></span>
                                <span x-show="currentTeam.id === team.id" class="ml-auto">✓</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 space-y-4">
            <!-- Team Avatars Showcase with Task Count -->
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-4">
                <h3 class="font-cinzel text-sm text-[#f1c40f] mb-4 text-center">
                    <span x-text="currentTeam.name"></span> - <span x-text="currentTeam.members.length"></span> Members
                </h3>
                <p class="text-xs text-gray-400 text-center mb-4">Tap avatar to view equipment</p>

                <!-- Avatar Grid with Task Count -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4">
                    <template x-for="member in currentTeam.members" :key="member.id">
                        <div class="text-center relative">
                            <!-- Task Count Badge -->
                            <div class="absolute -top-1 -right-1 z-10">
                                <div class="relative">
                                    <span class="bg-[#E74C3C] text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center border-2 border-[#1a1a2e]"
                                          x-text="member.tasks.doing + member.tasks.pending"></span>
                                </div>
                            </div>

                            <div class="avatar-clickable mx-auto w-16 sm:w-20 h-16 sm:h-20 rounded-full border-2 flex items-center justify-center overflow-hidden"
                                 :style="'background: ' + member.color + '20; border-color: ' + member.color"
                                 @click="openModal(member)">
                                <!-- Inline SVG based on member class -->
                                <div x-html="getMemberAvatar(member.id)" class="animate-idle"></div>
                            </div>
                            <p class="font-cinzel text-xs text-white mt-2" x-text="member.name"></p>
                            <p class="text-xs" :style="'color: ' + member.color">
                                Lv.<span x-text="member.level"></span>
                            </p>
                            <!-- Task Mini Summary -->
                            <div class="flex justify-center gap-1 mt-1">
                                <span class="text-xs px-1 rounded bg-[#F1C40F]/20 text-[#F1C40F]"
                                      x-text="member.tasks.doing + '⚔️'" title="Doing"></span>
                                <span class="text-xs px-1 rounded bg-[#3498DB]/20 text-[#3498DB]"
                                      x-text="member.tasks.pending + '📋'" title="Pending"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Team Progress Summary -->
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-4">
                <h3 class="font-cinzel text-sm text-[#f1c40f] mb-4">Guild Progress This Sprint</h3>

                <div class="grid grid-cols-3 gap-2 sm:gap-4 text-center">
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-[#2ECC71]" x-text="currentTeam.progress + '%'"></div>
                        <p class="text-[10px] sm:text-xs text-gray-400">Overall</p>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-[#F1C40F]" x-text="currentTeam.tasksDone"></div>
                        <p class="text-[10px] sm:text-xs text-gray-400">Tasks Done</p>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-[#9B59B6]" x-text="currentTeam.commanders"></div>
                        <p class="text-[10px] sm:text-xs text-gray-400">Commanders</p>
                    </div>
                </div>

                <!-- Sprint Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-400">Sprint Progress</span>
                        <span class="text-[#F1C40F]">Day 8/14</span>
                    </div>
                    <div class="h-2 bg-[#0f3460] rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#F1C40F] to-[#2ECC71] rounded-full"
                             :style="'width: ' + currentTeam.progress + '%'"></div>
                    </div>
                </div>
            </div>

            <!-- Battle Scenes - Each Member -->
            <div class="bg-[#16213e] border border-[#0f3460] rounded-xl p-4">
                <h3 class="font-cinzel text-sm text-[#f1c40f] mb-4 flex items-center gap-2">
                    <span>⚔️</span>
                    <span>Battle Status</span>
                    <span class="text-xs bg-[#E74C3C]/20 text-[#E74C3C] px-2 py-0.5 rounded-full ml-auto">
                        <span x-text="getTotalActiveTasks()"></span> Active Battles
                    </span>
                </h3>

                <div class="space-y-4">
                    <template x-for="member in currentTeam.members" :key="member.id">
                        <div x-show="member.tasks.doing > 0" class="bg-[#1a1a2e]/50 rounded-xl overflow-hidden">
                            <!-- Member Header -->
                            <div class="flex items-center gap-2 px-3 py-2 border-b border-[#0f3460]">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                     :style="'background: ' + member.color + '20'">
                                    <span x-text="member.icon"></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-cinzel text-white" x-text="member.name"></p>
                                    <p class="text-xs text-gray-400">Fighting <span x-text="member.tasks.doing"></span> monster(s)</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded bg-[#F1C40F]/20 text-[#F1C40F]">
                                    ⚔️ In Battle
                                </span>
                            </div>

                            <!-- Battle Scene -->
                            <div class="battle-scene relative h-28 sm:h-32 overflow-hidden">
                                <!-- Ground -->
                                <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-green-900/30 to-transparent"></div>

                                <!-- Hero (Left Side) -->
                                <div class="absolute left-4 bottom-8" x-html="getMemberBattleAvatar(member.id)"></div>

                                <!-- Attack Effect -->
                                <div class="absolute left-20 bottom-16 animate-slash">
                                    <svg width="30" height="30" viewBox="0 0 30 30">
                                        <path d="M5 25 L25 5" stroke="#f1c40f" stroke-width="3" stroke-linecap="round"/>
                                        <path d="M10 20 L20 10" stroke="#f1c40f" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>

                                <!-- Monsters (Right Side) - Based on task count -->
                                <div class="absolute right-2 bottom-6 flex items-end gap-1">
                                    <template x-for="(task, idx) in member.activeTasks.slice(0, 4)" :key="idx">
                                        <div class="relative" :style="'animation-delay: ' + (idx * 0.2) + 's'">
                                            <!-- Monster SVG -->
                                            <div x-html="getMonsterSvg(task.type, idx)" class="animate-monster"></div>
                                            <!-- Damage Number -->
                                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 text-[#E74C3C] font-bold text-xs animate-damage"
                                                 :style="'animation-delay: ' + (idx * 0.3) + 's'">
                                                -<span x-text="Math.floor(Math.random() * 50) + 10"></span>
                                            </div>
                                        </div>
                                    </template>
                                    <!-- More monsters indicator -->
                                    <div x-show="member.tasks.doing > 4"
                                         class="text-xs text-gray-400 bg-[#1a1a2e]/80 px-2 py-1 rounded">
                                        +<span x-text="member.tasks.doing - 4"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Task List -->
                            <div class="px-3 py-2 border-t border-[#0f3460] max-h-24 overflow-y-auto">
                                <template x-for="(task, idx) in member.activeTasks" :key="idx">
                                    <div class="flex items-center gap-2 py-1 text-xs">
                                        <span class="w-4 h-4 rounded flex items-center justify-center text-[10px]"
                                              :class="getTaskTypeClass(task.type)"
                                              x-text="task.type.charAt(0)"></span>
                                        <span class="text-gray-300 truncate flex-1" x-text="task.name"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Members not in battle -->
                    <div class="text-center py-2">
                        <p class="text-xs text-gray-500">Members at rest:</p>
                        <div class="flex justify-center gap-2 mt-2 flex-wrap">
                            <template x-for="member in currentTeam.members.filter(m => m.tasks.doing === 0)" :key="member.id">
                                <div class="flex items-center gap-1 bg-[#1a1a2e]/50 px-2 py-1 rounded text-xs">
                                    <span x-text="member.icon"></span>
                                    <span x-text="member.name" class="text-gray-400"></span>
                                    <span class="text-[#2ECC71]">✓</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Equipment Modal -->
        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70"
             @click.self="modalOpen = false">

            <div class="bg-[#16213e] border-2 border-[#f1c40f] rounded-xl w-full max-w-sm max-h-[80vh] overflow-y-auto"
                 x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="sticky top-0 bg-[#16213e] border-b border-[#0f3460] p-4 flex items-center justify-between">
                    <h3 class="font-cinzel text-lg text-[#f1c40f]" x-text="selectedMember?.name"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-white text-2xl">×</button>
                </div>

                <!-- Modal Content -->
                <div class="p-4" x-show="selectedMember">
                    <!-- Character Display -->
                    <div class="flex justify-center mb-4">
                        <div class="w-32 h-32 rounded-full border-4 border-[#f1c40f] flex items-center justify-center"
                             :style="'background: ' + selectedMember?.color + '20'">
                            <span class="text-6xl" x-text="selectedMember?.icon"></span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="text-center mb-4">
                        <p class="font-cinzel text-xl text-white" x-text="selectedMember?.name"></p>
                        <p class="text-sm" :style="'color: ' + selectedMember?.color" x-text="selectedMember?.class"></p>
                        <p class="text-xs text-gray-400">Level <span x-text="selectedMember?.level"></span></p>
                    </div>

                    <!-- Task Summary -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                            <p class="text-lg font-bold text-[#F1C40F]" x-text="selectedMember?.tasks?.doing || 0"></p>
                            <p class="text-xs text-gray-400">Doing</p>
                        </div>
                        <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                            <p class="text-lg font-bold text-[#3498DB]" x-text="selectedMember?.tasks?.pending || 0"></p>
                            <p class="text-xs text-gray-400">Pending</p>
                        </div>
                        <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                            <p class="text-lg font-bold text-[#2ECC71]" x-text="selectedMember?.tasks?.done || 0"></p>
                            <p class="text-xs text-gray-400">Done</p>
                        </div>
                    </div>

                    <!-- XP Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-400">Experience</span>
                            <span class="text-[#f1c40f]" x-text="selectedMember?.xp + ' / ' + selectedMember?.xpMax + ' XP'"></span>
                        </div>
                        <div class="h-2 bg-[#0f3460] rounded-full overflow-hidden">
                            <div class="h-full bg-[#f1c40f] rounded-full"
                                 :style="'width: ' + (selectedMember?.xp / selectedMember?.xpMax * 100) + '%'"></div>
                        </div>
                    </div>

                    <!-- Equipment Grid -->
                    <h4 class="font-cinzel text-sm text-[#f1c40f] mb-3">Equipment</h4>
                    <div class="grid grid-cols-3 gap-2">
                        <template x-for="(item, slot) in selectedMember?.equipment" :key="slot">
                            <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                                <div class="text-2xl mb-1" x-text="item.icon"></div>
                                <p class="text-xs text-gray-400 capitalize" x-text="slot"></p>
                                <p class="text-xs text-[#f1c40f] truncate" x-text="item.name"></p>
                            </div>
                        </template>
                    </div>

                    <!-- Combat Stats -->
                    <h4 class="font-cinzel text-sm text-[#f1c40f] mb-3 mt-4">Combat Stats</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                            <p class="text-lg font-bold text-[#2ECC71]" x-text="selectedMember?.kills"></p>
                            <p class="text-xs text-gray-400">Kills</p>
                        </div>
                        <div class="bg-[#1a1a2e] border border-[#0f3460] rounded-lg p-2 text-center">
                            <p class="text-lg font-bold text-[#f1c40f]" x-text="selectedMember?.gold"></p>
                            <p class="text-xs text-gray-400">Gold</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Tab Bar -->
        <nav class="fixed bottom-0 left-0 right-0 bg-[#16213e] border-t border-[#0f3460] z-40" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
            <div class="flex justify-around">
                <a href="{{ route('hero') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x2694;&#xFE0F;</div>
                    <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Hero</div>
                </a>
                <a href="{{ route('team') }}" class="flex-1 py-3 text-center text-[#f1c40f]" style="border-top: 3px solid #f1c40f;">
                    <div class="text-lg sm:text-xl">&#x1F465;</div>
                    <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Team</div>
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x1F5FA;&#xFE0F;</div>
                    <div class="text-[10px] sm:text-xs mt-1 font-cinzel">World</div>
                </a>
                <a href="{{ route('shop') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                    <div class="text-lg sm:text-xl">&#x1F6D2;</div>
                    <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Shop</div>
                </a>
            </div>
        </nav>
    </div>

    <script>
        function teamData() {
            return {
                modalOpen: false,
                selectedMember: null,
                currentTeam: @json($currentTeam),
                availableTeams: @json($teams),

                init() {
                    // Sync with Livewire
                    this.$wire.on('team-switched', (event) => {
                        this.currentTeam = event[0].team;
                    });
                },

                switchTeam(teamId) {
                    this.$wire.switchTeam(teamId);
                    this.$wire.on('team-switched', (event) => {
                        this.currentTeam = event[0].team;
                    });
                },

                getTotalActiveTasks() {
                    return this.currentTeam.members.reduce((sum, m) => sum + m.tasks.doing, 0);
                },

                openModal(member) {
                    this.selectedMember = member;
                    this.modalOpen = true;
                },

                getTaskTypeClass(type) {
                    const classes = {
                        'API': 'bg-[#9B59B6]/30 text-[#9B59B6]',
                        'FE': 'bg-[#1ABC9C]/30 text-[#1ABC9C]',
                        'UI': 'bg-[#E67E22]/30 text-[#E67E22]',
                        'AC': 'bg-[#3498DB]/30 text-[#3498DB]',
                        'Testing': 'bg-[#F1C40F]/30 text-[#F1C40F]',
                        'UAT': 'bg-[#2ECC71]/30 text-[#2ECC71]'
                    };
                    return classes[type] || 'bg-gray-500/30 text-gray-400';
                },

                getMemberAvatar(memberId) {
                    const avatars = {
                        ken: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 8 30 6 Q42 8 42 14 L40 18 L20 18 Z" fill="#4a3728"/>
                            <path d="M18 16 Q18 6 30 4 Q42 6 42 16 L40 12 L20 12 Z" fill="#718096"/>
                            <circle cx="30" cy="8" r="3" fill="#e74c3c"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <rect x="22" y="30" width="16" height="20" rx="3" fill="#4a5568"/>
                            <rect x="14" y="32" width="6" height="14" rx="2" fill="#4a5568"/>
                            <rect x="40" y="32" width="6" height="14" rx="2" fill="#4a5568"/>
                            <rect x="23" y="50" width="6" height="12" rx="2" fill="#4a5568"/>
                            <rect x="31" y="50" width="6" height="12" rx="2" fill="#4a5568"/>
                        </svg>`,
                        may: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M16 14 Q16 6 30 4 Q44 6 44 14 L44 35 Q30 38 16 35 Z" fill="#8B4513"/>
                            <path d="M20 16 L30 -2 L40 16 Z" fill="#1ABC9C"/>
                            <ellipse cx="30" cy="16" rx="12" ry="3" fill="#16a085"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M20 30 L18 65 L42 65 L40 30 Z" fill="#1ABC9C"/>
                        </svg>`,
                        ton: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 10 30 8 Q42 10 42 14 L40 16 L20 16 Z" fill="#E67E22"/>
                            <path d="M22 22 Q30 30 38 22 L36 18 L24 18 Z" fill="#4a3728"/>
                            <circle cx="26" cy="16" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="16" r="1.5" fill="#2d3748"/>
                            <rect x="20" y="30" width="20" height="25" rx="2" fill="#5d4e37"/>
                            <ellipse cx="15" cy="38" rx="5" ry="8" fill="#ffd5b5"/>
                            <ellipse cx="45" cy="38" rx="5" ry="8" fill="#ffd5b5"/>
                        </svg>`,
                        sarah: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 8 30 6 Q42 8 42 14 L40 20 L20 20 Z" fill="#2d3748"/>
                            <path d="M16 16 Q16 6 30 4 Q44 6 44 16 L42 12 L18 12 Z" fill="#3498DB" opacity="0.8"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M18 28 L14 65 L46 65 L42 28 Z" fill="#3498DB"/>
                        </svg>`,
                        nat: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 8 30 6 Q42 8 42 14 L42 22 Q30 24 18 22 Z" fill="#f5d0a9"/>
                            <rect x="20" y="6" width="20" height="8" rx="2" fill="white"/>
                            <rect x="28" y="4" width="4" height="6" fill="#e74c3c"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M20 30 L18 65 L42 65 L40 30 Z" fill="white"/>
                            <rect x="27" y="35" width="6" height="15" fill="#e74c3c"/>
                            <rect x="24" y="40" width="12" height="5" fill="#e74c3c"/>
                        </svg>`,
                        om: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 8 30 6 Q42 8 42 14 L40 18 L20 18 Z" fill="#2d3748"/>
                            <path d="M18 10 L22 2 L26 8 L30 0 L34 8 L38 2 L42 10 L40 14 L20 14 Z" fill="#f1c40f"/>
                            <circle cx="30" cy="6" r="2" fill="#e74c3c"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M18 30 L14 65 L46 65 L42 30 Z" fill="#9B59B6"/>
                            <rect x="28" y="30" width="4" height="30" fill="#f1c40f"/>
                        </svg>`,
                        anna: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M16 14 Q16 6 30 4 Q44 6 44 14 L44 30 Q30 32 16 30 Z" fill="#E74C3C"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M20 30 L18 65 L42 65 L40 30 Z" fill="#C0392B"/>
                        </svg>`,
                        bob: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 16 Q18 6 30 4 Q42 6 42 16 L40 12 L20 12 Z" fill="#95A5A6"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <rect x="20" y="30" width="20" height="25" rx="3" fill="#7F8C8D"/>
                        </svg>`,
                        clara: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M16 14 Q16 6 30 4 Q44 6 44 14 L44 28 Q30 30 16 28 Z" fill="#9B59B6"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M22 30 L20 65 L40 65 L38 30 Z" fill="#8E44AD"/>
                        </svg>`,
                        drake: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M18 14 Q18 6 30 2 Q42 6 42 14 L40 18 L20 18 Z" fill="#27AE60"/>
                            <path d="M16 12 L20 4 M44 12 L40 4" stroke="#27AE60" stroke-width="3"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <rect x="20" y="30" width="20" height="25" rx="3" fill="#229954"/>
                        </svg>`,
                        ember: `<svg width="50" height="60" viewBox="0 0 60 70">
                            <circle cx="30" cy="18" r="12" fill="#ffd5b5"/>
                            <path d="M16 14 Q16 6 30 4 Q44 6 44 14 L44 25 Q30 28 16 25 Z" fill="#F39C12"/>
                            <circle cx="30" cy="6" r="3" fill="#f1c40f"/>
                            <circle cx="26" cy="17" r="1.5" fill="#2d3748"/>
                            <circle cx="34" cy="17" r="1.5" fill="#2d3748"/>
                            <path d="M20 30 L18 65 L42 65 L40 30 Z" fill="#E67E22"/>
                        </svg>`
                    };
                    return avatars[memberId] || avatars.ken;
                },

                getMemberBattleAvatar(memberId) {
                    return `<div class="animate-idle">${this.getMemberAvatar(memberId)}</div>`;
                },

                getMonsterSvg(type, index) {
                    const monsters = {
                        'API': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <ellipse cx="25" cy="45" rx="20" ry="8" fill="#6B21A8" opacity="0.5"/>
                            <ellipse cx="25" cy="35" rx="18" ry="18" fill="#9B59B6"/>
                            <ellipse cx="25" cy="32" rx="15" ry="14" fill="#A855F7"/>
                            <circle cx="18" cy="30" r="4" fill="white"/>
                            <circle cx="32" cy="30" r="4" fill="white"/>
                            <circle cx="19" cy="31" r="2" fill="#2d3748"/>
                            <circle cx="33" cy="31" r="2" fill="#2d3748"/>
                            <ellipse cx="25" cy="40" rx="5" ry="3" fill="#6B21A8"/>
                        </svg>`,
                        'FE': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <ellipse cx="25" cy="50" rx="12" ry="4" fill="#0D9488" opacity="0.3"/>
                            <ellipse cx="25" cy="35" rx="12" ry="14" fill="#1ABC9C"/>
                            <circle cx="25" cy="18" r="12" fill="#16A085"/>
                            <polygon points="15,12 18,0 22,10" fill="#1ABC9C"/>
                            <polygon points="35,12 32,0 28,10" fill="#1ABC9C"/>
                            <circle cx="20" cy="17" r="3" fill="white"/>
                            <circle cx="30" cy="17" r="3" fill="white"/>
                            <circle cx="21" cy="18" r="1.5" fill="red"/>
                            <circle cx="31" cy="18" r="1.5" fill="red"/>
                            <path d="M20 26 Q25 30 30 26" stroke="#0D9488" fill="none" stroke-width="2"/>
                            <rect x="13" y="30" width="4" height="12" rx="2" fill="#16A085"/>
                            <rect x="33" y="30" width="4" height="12" rx="2" fill="#16A085"/>
                        </svg>`,
                        'UI': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <path d="M5 25 Q15 10 25 20 Q35 10 45 25 Q35 35 25 28 Q15 35 5 25" fill="#E67E22"/>
                            <circle cx="25" cy="28" r="8" fill="#D35400"/>
                            <circle cx="22" cy="26" r="2" fill="white"/>
                            <circle cx="28" cy="26" r="2" fill="white"/>
                            <circle cx="22" cy="27" r="1" fill="#2d3748"/>
                            <circle cx="28" cy="27" r="1" fill="#2d3748"/>
                            <polygon points="23,32 25,36 27,32" fill="#C0392B"/>
                        </svg>`,
                        'AC': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <ellipse cx="25" cy="50" rx="10" ry="3" fill="#2980B9" opacity="0.3"/>
                            <path d="M10 30 Q10 10 25 10 Q40 10 40 30 L40 45 Q35 40 30 45 Q25 40 20 45 Q15 40 10 45 Z" fill="#3498DB"/>
                            <circle cx="18" cy="25" r="4" fill="white"/>
                            <circle cx="32" cy="25" r="4" fill="white"/>
                            <circle cx="19" cy="26" r="2" fill="#1a1a2e"/>
                            <circle cx="33" cy="26" r="2" fill="#1a1a2e"/>
                            <ellipse cx="25" cy="35" rx="4" ry="3" fill="#1a1a2e"/>
                        </svg>`,
                        'Testing': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <ellipse cx="25" cy="50" rx="8" ry="3" fill="#D4AC0D" opacity="0.3"/>
                            <ellipse cx="25" cy="30" rx="12" ry="10" fill="#F1C40F"/>
                            <circle cx="25" cy="18" r="10" fill="#D4AC0D"/>
                            <circle cx="20" cy="16" r="3" fill="black"/>
                            <circle cx="30" cy="16" r="3" fill="black"/>
                            <circle cx="20" cy="15" r="1" fill="red"/>
                            <circle cx="30" cy="15" r="1" fill="red"/>
                            <path d="M8 25 Q5 20 10 25 L15 28" stroke="#D4AC0D" stroke-width="3" fill="none"/>
                            <path d="M42 25 Q45 20 40 25 L35 28" stroke="#D4AC0D" stroke-width="3" fill="none"/>
                            <path d="M6 35 Q3 32 8 35 L15 35" stroke="#D4AC0D" stroke-width="3" fill="none"/>
                            <path d="M44 35 Q47 32 42 35 L35 35" stroke="#D4AC0D" stroke-width="3" fill="none"/>
                        </svg>`,
                        'UAT': `<svg width="40" height="45" viewBox="0 0 50 55">
                            <rect x="20" y="35" width="10" height="15" fill="#F5F5DC"/>
                            <ellipse cx="25" cy="35" rx="18" ry="12" fill="#2ECC71"/>
                            <circle cx="18" cy="32" r="4" fill="#27AE60"/>
                            <circle cx="32" cy="30" r="3" fill="#27AE60"/>
                            <circle cx="25" cy="38" r="2" fill="#27AE60"/>
                            <circle cx="20" cy="42" r="2" fill="white"/>
                            <circle cx="30" cy="42" r="2" fill="white"/>
                            <circle cx="20" cy="43" r="1" fill="#2d3748"/>
                            <circle cx="30" cy="43" r="1" fill="#2d3748"/>
                        </svg>`
                    };
                    return monsters[type] || monsters['API'];
                }
            }
        }
    </script>
</div>
