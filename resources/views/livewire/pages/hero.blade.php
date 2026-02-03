<div x-data="heroData()" class="min-h-screen pb-20" style="background-color: #1a1a2e;">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600;700&display=swap');

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }

        @keyframes hero-idle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        @keyframes monster-idle {
            0%, 100% { transform: translateY(0) scaleX(-1); }
            50% { transform: translateY(-3px) scaleX(-1); }
        }
        @keyframes attack-slash {
            0% { opacity: 0; transform: translateX(-20px) rotate(-45deg); }
            50% { opacity: 1; }
            100% { opacity: 0; transform: translateX(20px) rotate(45deg); }
        }
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 10px rgba(241, 196, 15, 0.3); }
            50% { box-shadow: 0 0 20px rgba(241, 196, 15, 0.6); }
        }
        .animate-hero { animation: hero-idle 2s ease-in-out infinite; }
        .animate-monster { animation: monster-idle 1.5s ease-in-out infinite; }
        .animate-attack { animation: attack-slash 0.8s ease-out infinite; }
        .animate-pulse-gold { animation: pulse-gold 2s ease-in-out infinite; }
        .equipment-slot {
            cursor: pointer;
            transition: all 0.2s;
        }
        .equipment-slot:hover {
            transform: scale(1.05);
            border-color: #f1c40f;
        }
        .equipment-slot.selected {
            border-color: #f1c40f;
            box-shadow: 0 0 10px rgba(241, 196, 15, 0.5);
        }
    </style>

    <!-- Header -->
    <header class="sticky top-0 z-40 backdrop-blur border-b" style="background-color: rgba(26, 26, 46, 0.95); border-color: #0f3460;">
        <div class="flex items-center justify-between px-4 py-3">
            <div>
                <h1 class="font-cinzel text-xl" style="color: #f1c40f;">Hero Dashboard</h1>
                <p class="text-gray-500 text-xs">{{ $hero['name'] }} - {{ $hero['class'] }}</p>
            </div>
            <!-- Currency Display -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1 px-2 py-1 rounded-lg border" style="background-color: #16213e; border-color: #0f3460;">
                    <span style="color: #f1c40f;">💰</span>
                    <span class="text-sm font-bold" style="color: #f1c40f;">{{ number_format($stats['gold']) }}</span>
                </div>
                <div class="flex items-center gap-1 px-2 py-1 rounded-lg border" style="background-color: #16213e; border-color: #0f3460;">
                    <span class="text-purple-500">💎</span>
                    <span class="text-sm font-bold text-purple-500">{{ $stats['gems'] }}</span>
                </div>
            </div>
        </div>
    </header>

    <main class="p-4 space-y-4">

        <!-- Character Card with Equipment -->
        <div class="rounded-xl p-4 animate-pulse-gold border" style="background-color: #16213e; border-color: #f1c40f;">
            <div class="flex items-start gap-4">
                <!-- Character Avatar with Equipment -->
                <div class="relative">
                    <div class="animate-hero">
                        <svg width="100" height="120" viewBox="0 0 100 120" class="drop-shadow-lg">
                            <!-- Character Body (Warrior) -->
                            <circle cx="50" cy="25" r="20" fill="#ffd5b5"/>
                            <path d="M32 20 Q35 5 50 8 Q65 5 68 20 Q68 15 50 12 Q32 15 32 20" fill="#4a3728"/>
                            <circle cx="43" cy="22" r="3" fill="#2d3748"/>
                            <circle cx="57" cy="22" r="3" fill="#2d3748"/>
                            <path d="M45 32 Q50 36 55 32" stroke="#c97b63" stroke-width="2" fill="none"/>
                            <!-- Helmet -->
                            <path d="M30 18 Q30 5 50 3 Q70 5 70 18 L68 25 Q50 22 32 25 Z" fill="#718096" stroke="#a0aec0" stroke-width="1"/>
                            <circle cx="50" cy="8" r="4" fill="#e74c3c"/>
                            <!-- Body/Armor -->
                            <rect x="35" y="45" width="30" height="35" rx="5" fill="#4a5568"/>
                            <rect x="38" y="48" width="24" height="10" fill="#718096"/>
                            <circle cx="50" cy="53" r="3" fill="#f1c40f"/>
                            <!-- Arms -->
                            <rect x="22" y="48" width="13" height="30" rx="4" fill="#ffd5b5"/>
                            <rect x="65" y="48" width="13" height="30" rx="4" fill="#ffd5b5"/>
                            <rect x="22" y="48" width="13" height="15" rx="3" fill="#4a5568"/>
                            <rect x="65" y="48" width="13" height="15" rx="3" fill="#4a5568"/>
                            <!-- Sword -->
                            <rect x="78" y="55" width="4" height="35" fill="#a0aec0"/>
                            <rect x="75" y="52" width="10" height="5" fill="#f1c40f"/>
                            <polygon points="80,55 76,45 84,45" fill="#a0aec0"/>
                            <!-- Shield -->
                            <ellipse cx="15" cy="65" rx="12" ry="15" fill="#2d3748" stroke="#f1c40f" stroke-width="2"/>
                            <circle cx="15" cy="65" r="5" fill="#f1c40f"/>
                            <!-- Legs & Boots -->
                            <rect x="38" y="80" width="10" height="25" rx="3" fill="#ffd5b5"/>
                            <rect x="52" y="80" width="10" height="25" rx="3" fill="#ffd5b5"/>
                            <rect x="38" y="80" width="10" height="15" rx="2" fill="#4a5568"/>
                            <rect x="52" y="80" width="10" height="15" rx="2" fill="#4a5568"/>
                            <rect x="36" y="103" width="14" height="10" rx="3" fill="#5d4e37"/>
                            <rect x="50" y="103" width="14" height="10" rx="3" fill="#5d4e37"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full text-sm font-bold" style="background-color: #f1c40f; color: #1a1a2e;">
                        Lv.{{ $hero['level'] }}
                    </div>
                </div>

                <!-- Character Info -->
                <div class="flex-1">
                    <h2 class="font-cinzel text-xl text-white">{{ $hero['name'] }}</h2>
                    <p class="text-purple-500 text-sm">⚔️ {{ $hero['class'] }} ({{ $hero['role'] }})</p>

                    <!-- XP Bar -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-400">Experience</span>
                            <span style="color: #f1c40f;">{{ number_format($hero['xp']) }} / {{ number_format($hero['xpMax']) }} XP</span>
                        </div>
                        <div class="h-3 rounded-full overflow-hidden" style="background-color: #0f3460;">
                            <div class="h-full rounded-full" style="width: {{ ($hero['xp'] / $hero['xpMax']) * 100 }}%; background: linear-gradient(to right, #d4a906, #f1c40f);"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($hero['xpMax'] - $hero['xp']) }} XP to Level {{ $hero['level'] + 1 }}</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-2 mt-3">
                        <div class="text-center rounded-lg p-2" style="background-color: rgba(26, 26, 46, 0.5);">
                            <div class="text-lg font-bold text-green-500">{{ $stats['kills'] }}</div>
                            <p class="text-xs text-gray-500">Kills</p>
                        </div>
                        <div class="text-center rounded-lg p-2" style="background-color: rgba(26, 26, 46, 0.5);">
                            <div class="text-lg font-bold" style="color: #f1c40f;">{{ number_format($stats['gold']) }}</div>
                            <p class="text-xs text-gray-500">Gold</p>
                        </div>
                        <div class="text-center rounded-lg p-2" style="background-color: rgba(26, 26, 46, 0.5);">
                            <div class="text-lg font-bold text-purple-500">{{ $stats['gems'] }}</div>
                            <p class="text-xs text-gray-500">Gems</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Battle Scene -->
        <div class="rounded-xl p-4 border" style="background: linear-gradient(to right, #16213e, #1a1a2e, #16213e); border-color: #f1c40f;">
            <h3 class="font-cinzel text-sm mb-3 flex items-center gap-2" style="color: #f1c40f;">
                <span>⚔️</span>
                <span>Currently Fighting</span>
                <span class="text-xs px-2 py-0.5 rounded-full" style="background-color: rgba(241, 196, 15, 0.2);">{{ count($activeTasks) }} Minions</span>
            </h3>

            <!-- Battle Arena -->
            <div class="relative rounded-xl p-4 min-h-[140px] overflow-hidden" style="background-color: rgba(26, 26, 46, 0.5);">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-green-900 to-transparent"></div>
                </div>

                <div class="relative flex items-center justify-between">
                    <!-- Hero (Left Side) -->
                    <div class="flex flex-col items-center">
                        <div class="animate-hero">
                            <svg width="60" height="80" viewBox="0 0 100 120" class="drop-shadow-lg">
                                <circle cx="50" cy="25" r="18" fill="#ffd5b5"/>
                                <path d="M32 20 Q35 8 50 10 Q65 8 68 20" fill="#4a3728"/>
                                <path d="M30 18 Q30 5 50 3 Q70 5 70 18 L68 22 Q50 20 32 22 Z" fill="#718096"/>
                                <circle cx="50" cy="8" r="3" fill="#e74c3c"/>
                                <circle cx="43" cy="22" r="2" fill="#2d3748"/>
                                <circle cx="57" cy="22" r="2" fill="#2d3748"/>
                                <rect x="35" y="43" width="30" height="30" rx="5" fill="#4a5568"/>
                                <rect x="38" y="46" width="24" height="8" fill="#718096"/>
                                <rect x="75" y="50" width="3" height="25" fill="#a0aec0"/>
                                <rect x="73" y="48" width="7" height="4" fill="#f1c40f"/>
                                <ellipse cx="20" cy="55" rx="8" ry="10" fill="#2d3748" stroke="#f1c40f" stroke-width="1"/>
                                <rect x="38" y="73" width="10" height="20" rx="3" fill="#4a5568"/>
                                <rect x="52" y="73" width="10" height="20" rx="3" fill="#4a5568"/>
                            </svg>
                        </div>
                        <span class="text-xs mt-1 font-bold" style="color: #f1c40f;">{{ $hero['name'] }}</span>
                    </div>

                    <!-- Attack Effects -->
                    <div class="flex-1 flex items-center justify-center">
                        <div class="relative">
                            <span class="animate-attack text-2xl absolute">⚔️</span>
                            <span class="text-gray-500 text-xs">VS</span>
                        </div>
                    </div>

                    <!-- Monsters -->
                    <div class="flex items-end gap-2">
                        @foreach($activeTasks as $index => $task)
                        <div class="flex flex-col items-center">
                            <div class="animate-monster" style="animation-delay: {{ $index * 0.2 }}s;">
                                <svg width="45" height="55" viewBox="0 0 60 70" class="drop-shadow-lg">
                                    <ellipse cx="30" cy="55" rx="25" ry="12" fill="#7c3aed" opacity="0.5"/>
                                    <ellipse cx="30" cy="40" rx="22" ry="25" fill="#9B59B6"/>
                                    <ellipse cx="30" cy="35" rx="18" ry="20" fill="#a855f7"/>
                                    <circle cx="22" cy="35" r="5" fill="white"/>
                                    <circle cx="38" cy="35" r="5" fill="white"/>
                                    <circle cx="23" cy="36" r="2" fill="#1a1a2e"/>
                                    <circle cx="39" cy="36" r="2" fill="#1a1a2e"/>
                                    <text x="30" y="52" text-anchor="middle" font-size="10">{{ $task['icon'] }}</text>
                                </svg>
                            </div>
                            <span class="text-xs mt-1 {{ $task['color'] }}">{{ explode(' ', $task['flow'])[0] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Active Tasks List (Doing) -->
            <div class="mt-3 space-y-2">
                @foreach($activeTasks as $task)
                <div class="flex items-center gap-2 rounded-lg p-2" style="background-color: rgba(26, 26, 46, 0.5);">
                    <span class="{{ $task['color'] }}">{{ $task['icon'] }}</span>
                    <div class="flex-1">
                        <p class="text-sm text-white">{{ $task['name'] }}</p>
                        <p class="text-xs text-gray-500">Flow: {{ $task['flow'] }}</p>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded" style="background-color: rgba(241, 196, 15, 0.2); color: #f1c40f;">{{ $task['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="rounded-xl p-4 border" style="background-color: #16213e; border-color: #0f3460;">
            <h3 class="font-cinzel text-sm mb-3 flex items-center gap-2" style="color: #f1c40f;">
                <span>📋</span>
                <span>Pending Tasks</span>
                <span class="text-xs px-2 py-0.5 rounded-full" style="background-color: #0f3460; color: #9ca3af;">{{ count($pendingTasks) }} waiting</span>
            </h3>

            <div class="space-y-2">
                @foreach($pendingTasks as $task)
                <div class="flex items-center gap-2 rounded-lg p-2 opacity-70" style="background-color: rgba(26, 26, 46, 0.3);">
                    <span class="{{ $task['color'] }}">{{ $task['icon'] }}</span>
                    <div class="flex-1">
                        <p class="text-sm text-white">{{ $task['name'] }}</p>
                        <p class="text-xs text-gray-500">Flow: {{ $task['flow'] }}</p>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded" style="background-color: rgba(75, 85, 99, 0.3); color: #9ca3af;">{{ $task['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Equipment + Inventory -->
        <div class="rounded-xl p-4 border" style="background-color: #16213e; border-color: #0f3460;">
            <!-- Tabs -->
            <div class="flex border-b mb-4" style="border-color: #0f3460;">
                <button @click="activeTab = 'equipment'"
                        :class="activeTab === 'equipment' ? 'border-b-2' : 'text-gray-400'"
                        class="flex-1 py-2 text-sm font-cinzel"
                        :style="activeTab === 'equipment' ? 'color: #f1c40f; border-color: #f1c40f;' : ''">
                    🛡️ Equipment
                </button>
                <button @click="activeTab = 'inventory'"
                        :class="activeTab === 'inventory' ? 'border-b-2' : 'text-gray-400'"
                        class="flex-1 py-2 text-sm font-cinzel"
                        :style="activeTab === 'inventory' ? 'color: #f1c40f; border-color: #f1c40f;' : ''">
                    🎒 Inventory <span class="text-xs text-gray-500">({{ count($inventory) }})</span>
                </button>
            </div>

            <!-- Equipment Tab -->
            <div x-show="activeTab === 'equipment'">
                <div class="grid grid-cols-3 gap-2">
                    @foreach($equipment as $key => $slot)
                    <div class="equipment-slot rounded-lg p-2 text-center border"
                         style="background-color: rgba(26, 26, 46, 0.5); border-color: #0f3460;"
                         :class="{ 'selected': selectedSlot === '{{ $key }}' }"
                         @click="selectSlot('{{ $key }}')">
                        <div class="text-2xl">{{ $slot['icon'] }}</div>
                        <p class="text-xs text-gray-400 capitalize">{{ $slot['label'] }}</p>
                        <p class="text-xs truncate {{ $slot['item'] ? 'text-green-500' : 'text-gray-600' }}">{{ $slot['item'] ?: 'Empty' }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Selected Slot Actions -->
                <div x-show="selectedSlot" class="mt-4 p-3 rounded-lg border" style="background-color: rgba(26, 26, 46, 0.5); border-color: #f1c40f;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold" style="color: #f1c40f;" x-text="getSlotItem(selectedSlot)"></p>
                            <p class="text-xs text-gray-400" x-text="'Slot: ' + selectedSlot"></p>
                        </div>
                        <div class="flex gap-2">
                            <button x-show="getSlotItem(selectedSlot) !== 'No item equipped'"
                                    @click="unequipItem()"
                                    class="px-3 py-1 text-xs rounded hover:bg-red-500/30"
                                    style="background-color: rgba(239, 68, 68, 0.2); color: #ef4444;">
                                Unequip
                            </button>
                            <button @click="showInventoryForSlot()"
                                    class="px-3 py-1 text-xs rounded hover:bg-yellow-500/30"
                                    style="background-color: rgba(241, 196, 15, 0.2); color: #f1c40f;">
                                Change
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Tab -->
            <div x-show="activeTab === 'inventory'">
                <div class="grid grid-cols-4 gap-2">
                    @foreach($inventory as $item)
                    <div class="equipment-slot rounded-lg p-2 text-center border cursor-pointer"
                         style="background-color: rgba(26, 26, 46, 0.5); border-color: {{ $item['equipped'] ? '#f1c40f' : '#0f3460' }};"
                         @click="selectInventoryItem({{ json_encode($item) }})">
                        <div class="text-2xl">{{ $item['icon'] }}</div>
                        <p class="text-xs text-white truncate">{{ $item['name'] }}</p>
                        <p class="text-xs {{ $item['equipped'] ? 'text-green-500' : 'text-gray-500' }}">{{ $item['equipped'] ? 'Equipped' : $item['type'] }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Selected Item Actions -->
                <div x-show="selectedItem" class="mt-4 p-3 rounded-lg border" style="background-color: rgba(26, 26, 46, 0.5); border-color: #f1c40f;">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl" x-text="selectedItem?.icon"></div>
                        <div class="flex-1">
                            <p class="text-sm font-bold" style="color: #f1c40f;" x-text="selectedItem?.name"></p>
                            <p class="text-xs text-gray-400" x-text="'Type: ' + selectedItem?.type + ' | Slot: ' + selectedItem?.slot"></p>
                            <p class="text-xs text-blue-400" x-text="selectedItem?.stats"></p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <button x-show="selectedItem && !selectedItem.equipped && selectedItem.slot !== '-'"
                                @click="equipItem()"
                                class="flex-1 px-3 py-2 text-xs rounded hover:bg-green-500/30"
                                style="background-color: rgba(34, 197, 94, 0.2); color: #22c55e;">
                            ⬆️ Equip
                        </button>
                        <button x-show="selectedItem?.equipped"
                                @click="unequipFromInventory()"
                                class="flex-1 px-3 py-2 text-xs rounded hover:bg-yellow-500/30"
                                style="background-color: rgba(241, 196, 15, 0.2); color: #f1c40f;">
                            ⬇️ Unequip
                        </button>
                        <button class="px-3 py-2 text-xs rounded hover:bg-gray-600/80"
                                style="background-color: #0f3460; color: #9ca3af;">
                            🔍 Details
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Damage Contribution -->
        <div class="rounded-xl p-4 border" style="background-color: #16213e; border-color: #0f3460;">
            <h3 class="font-cinzel text-sm mb-3" style="color: #f1c40f;">Damage Contribution by Type</h3>
            <div class="flex items-center gap-1 h-6 rounded-full overflow-hidden">
                <div class="h-full" style="width: 5%; background: #E67E22;" title="Design 5%"></div>
                <div class="h-full" style="width: 5%; background: #3498DB;" title="AC 5%"></div>
                <div class="h-full" style="width: 70%; background: #9B59B6;" title="API 70%"></div>
                <div class="h-full" style="width: 15%; background: #1ABC9C;" title="FE 15%"></div>
                <div class="h-full" style="width: 5%; background: #F1C40F;" title="Testing 5%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-400 mt-2">
                <span style="color: #E67E22;">📐 5%</span>
                <span style="color: #3498DB;">📋 5%</span>
                <span style="color: #9B59B6;">⚙️ 70%</span>
                <span style="color: #1ABC9C;">💻 15%</span>
                <span style="color: #F1C40F;">🧪 5%</span>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="rounded-xl p-4 border" style="background-color: #16213e; border-color: #0f3460;">
            <h3 class="font-cinzel text-sm mb-3 flex items-center gap-2" style="color: #f1c40f;">
                <span>Recent Activity</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-inter" style="background-color: #0f3460; color: #9ca3af;">📅 This Week</span>
            </h3>
            <div class="space-y-3">
                @foreach($recentActivity as $activity)
                <div class="flex items-start gap-3">
                    <div class="text-xl">{{ $activity['icon'] }}</div>
                    <div class="flex-1">
                        <p class="text-sm text-white">{{ explode(':', $activity['title'])[0] }}: <span class="{{ $activity['highlight'] }}">{{ explode(':', $activity['title'])[1] ?? '' }}</span></p>
                        <p class="text-xs text-gray-500">{{ $activity['meta'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </main>

    <!-- Bottom Tab Bar -->
    <nav class="fixed bottom-0 left-0 right-0 border-t z-50" style="background-color: #16213e; border-color: #0f3460;">
        <div class="flex justify-around">
            <a href="{{ route('hero') }}" class="flex-1 py-3 text-center" style="color: #f1c40f; border-bottom: 3px solid #f1c40f;">
                <div class="text-xl">⚔️</div>
                <div class="text-xs mt-1">Hero</div>
            </a>
            <a href="#" class="flex-1 py-3 text-center text-gray-400 hover:text-yellow-400">
                <div class="text-xl">👥</div>
                <div class="text-xs mt-1">Team</div>
            </a>
            <a href="{{ route('dashboard') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-yellow-400">
                <div class="text-xl">🗺️</div>
                <div class="text-xs mt-1">World</div>
            </a>
            <a href="#" class="flex-1 py-3 text-center text-gray-400 hover:text-yellow-400">
                <div class="text-xl">🛒</div>
                <div class="text-xs mt-1">Shop</div>
            </a>
        </div>
    </nav>

    <script>
        function heroData() {
            return {
                activeTab: 'equipment',
                selectedSlot: null,
                selectedItem: null,
                equipmentSlots: @json($equipment),
                inventory: @json($inventory),
                selectSlot(slot) {
                    this.selectedSlot = this.selectedSlot === slot ? null : slot;
                },
                selectInventoryItem(item) {
                    this.selectedItem = this.selectedItem?.id === item.id ? null : item;
                },
                getSlotItem(slot) {
                    return this.equipmentSlots[slot]?.item || 'No item equipped';
                },
                unequipItem() {
                    if (this.selectedSlot && this.equipmentSlots[this.selectedSlot].item) {
                        const item = this.inventory.find(i => i.name === this.equipmentSlots[this.selectedSlot].item);
                        if (item) item.equipped = false;
                        this.equipmentSlots[this.selectedSlot].item = null;
                        this.selectedSlot = null;
                    }
                },
                equipItem() {
                    if (this.selectedItem && !this.selectedItem.equipped && this.selectedItem.slot !== '-') {
                        const slot = this.selectedItem.slot;
                        const slotKey = slot === 'head' ? 'head' : slot === 'body' ? 'body' : slot === 'rhand' ? 'rhand' : slot === 'lhand' ? 'lhand' : slot === 'legs' ? 'legs' : 'feet';
                        const currentItem = this.equipmentSlots[slotKey]?.item;
                        if (currentItem) {
                            const cur = this.inventory.find(i => i.name === currentItem);
                            if (cur) cur.equipped = false;
                        }
                        this.equipmentSlots[slotKey].item = this.selectedItem.name;
                        this.selectedItem.equipped = true;
                        this.selectedItem = null;
                    }
                },
                unequipFromInventory() {
                    if (this.selectedItem && this.selectedItem.equipped) {
                        const slot = this.selectedItem.slot;
                        const slotKey = slot === 'head' ? 'head' : slot === 'body' ? 'body' : slot === 'rhand' ? 'rhand' : slot === 'lhand' ? 'lhand' : slot === 'legs' ? 'legs' : 'feet';
                        this.equipmentSlots[slotKey].item = null;
                        this.selectedItem.equipped = false;
                        this.selectedItem = null;
                    }
                },
                showInventoryForSlot() {
                    this.activeTab = 'inventory';
                    this.selectedSlot = null;
                }
            }
        }
    </script>
</div>
