<div class="min-h-screen bg-[#1a1a2e] pb-24">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600;700&display=swap');

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }

        .item-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(241, 196, 15, 0.2);
        }
        .item-card.locked {
            opacity: 0.5;
            filter: grayscale(0.5);
        }

        .rarity-common { border-color: #95a5a6; }
        .rarity-rare { border-color: #3498db; }
        .rarity-epic { border-color: #9b59b6; }
        .rarity-legendary { border-color: #f1c40f; }

        .rarity-badge-common { background-color: rgba(149, 165, 166, 0.2); color: #95a5a6; }
        .rarity-badge-rare { background-color: rgba(52, 152, 219, 0.2); color: #3498db; }
        .rarity-badge-epic { background-color: rgba(155, 89, 182, 0.2); color: #9b59b6; }
        .rarity-badge-legendary { background-color: rgba(241, 196, 15, 0.2); color: #f1c40f; }

        .tab-active {
            border-bottom: 3px solid #f1c40f;
            color: #f1c40f;
        }
    </style>

    <!-- Header -->
    <header class="sticky top-0 z-40 bg-[#1a1a2e]/95 backdrop-blur border-b border-[#0f3460]">
        <div class="flex items-center justify-between px-4 py-3">
            <div>
                <h1 class="font-cinzel text-xl text-[#f1c40f]">🛒 Shop</h1>
                <p class="text-gray-500 text-xs">Buy cosmetics with Gold</p>
            </div>
            <!-- Currency Display -->
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="flex items-center gap-1 text-xs sm:text-sm bg-[#16213e] px-2 sm:px-3 py-1.5 rounded-lg border border-[#0f3460]">
                    <span>🪙</span>
                    <span class="text-[#f1c40f] font-medium">{{ number_format($userGold) }}</span>
                </div>
                <div class="flex items-center gap-1 text-xs sm:text-sm bg-[#16213e] px-2 sm:px-3 py-1.5 rounded-lg border border-[#0f3460]">
                    <span>💎</span>
                    <span class="text-[#3498db] font-medium">{{ number_format($userGems) }}</span>
                </div>
            </div>
        </div>
    </header>

    <main class="p-4 space-y-6">
        <!-- Info Banner -->
        <div class="bg-[#f1c40f]/10 border border-[#f1c40f]/30 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💡</span>
                <div>
                    <p class="text-sm text-[#f1c40f] font-medium">Cosmetic Only</p>
                    <p class="text-xs text-gray-400 mt-1">Items are cosmetic only and do not affect gameplay stats.</p>
                </div>
            </div>
        </div>

        <!-- Gem Redemption Notice -->
        <div class="bg-[#3498db]/10 border border-[#3498db]/30 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💎</span>
                <div>
                    <p class="text-sm text-[#3498db] font-medium">Gem = Real Incentive</p>
                    <p class="text-xs text-gray-400 mt-1">Earn Gems by defeating Commanders — redeem for real rewards at HR</p>
                    <p class="text-xs text-gray-500 mt-1">Your Gems: <span class="text-[#3498db] font-medium">{{ number_format($userGems) }} 💎</span></p>
                </div>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="flex gap-2 overflow-x-auto pb-2">
            @foreach($categories as $category)
                <button
                    wire:click="filterByCategory('{{ $category }}')"
                    class="px-3 py-2 sm:px-4 text-xs sm:text-sm font-medium whitespace-nowrap transition-colors {{ $selectedCategory === $category ? 'tab-active' : 'text-gray-400 hover:text-[#f1c40f]' }}"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- Shop Items Grid -->
        <div class="grid grid-cols-2 gap-2 sm:gap-3">
            @foreach($filteredItems as $item)
                @php
                    $isLocked = $userLevel < $item['required_level'];
                    $rarityClass = 'rarity-' . $item['rarity'];
                    $rarityBadgeClass = 'rarity-badge-' . $item['rarity'];
                    $borderColor = $item['owned'] ? '#2ecc71' : ($isLocked ? '#374151' : match($item['rarity']) {
                        'common' => '#95a5a6',
                        'rare' => '#3498db',
                        'epic' => '#9b59b6',
                        'legendary' => '#f1c40f',
                        default => '#0f3460'
                    });
                @endphp

                <div class="item-card {{ $isLocked ? 'locked' : '' }} bg-[#16213e] border rounded-xl p-3 text-center"
                     style="border-color: {{ $borderColor }}">
                    <!-- Rarity Badge -->
                    <div class="flex justify-end mb-1">
                        <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 rounded {{ $rarityBadgeClass }}">
                            {{ $item['rarity'] }}
                        </span>
                    </div>

                    <div class="text-3xl sm:text-4xl mb-2">{{ $item['icon'] }}</div>
                    <h3 class="text-xs sm:text-sm text-white font-medium line-clamp-2">{{ $item['name'] }}</h3>
                    <p class="text-xs text-gray-500">Lv.{{ $item['required_level'] }} Required</p>

                    @if($item['owned'])
                        <div class="mt-2">
                            <span class="text-xs bg-[#2ecc71]/20 text-[#2ecc71] px-2 py-1 rounded">
                                {{ $item['equipped'] ? '✓ Equipped' : '✓ Owned' }}
                            </span>
                        </div>
                    @elseif($isLocked)
                        <div class="mt-2 flex items-center justify-center gap-1">
                            @if($item['currency'] === 'gold')
                                <span class="text-gray-500">🪙</span>
                                <span class="text-gray-500">{{ number_format($item['price']) }}</span>
                            @else
                                <span class="text-gray-500">💎</span>
                                <span class="text-gray-500">{{ number_format($item['price']) }}</span>
                            @endif
                        </div>
                        <button disabled class="mt-2 w-full py-2 bg-gray-700 text-gray-500 text-xs sm:text-sm rounded-lg cursor-not-allowed">
                            🔒 Lv.{{ $item['required_level'] }}
                        </button>
                    @else
                        <div class="mt-2 flex items-center justify-center gap-1">
                            @if($item['currency'] === 'gold')
                                <span>🪙</span>
                                <span class="text-[#f1c40f] font-medium">{{ number_format($item['price']) }}</span>
                            @else
                                <span>💎</span>
                                <span class="text-[#3498db] font-medium">{{ number_format($item['price']) }}</span>
                            @endif
                        </div>
                        <button
                            wire:click="purchaseItem({{ $item['id'] }})"
                            class="mt-2 w-full py-2 bg-[#f1c40f] text-[#1a1a2e] text-xs sm:text-sm font-medium rounded-lg hover:bg-[#d4a906] transition-colors"
                        >
                            Buy
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        @if(count($filteredItems) === 0)
            <div class="text-center py-12">
                <div class="text-4xl mb-2">📦</div>
                <p class="text-gray-400 text-sm">No items in this category</p>
            </div>
        @endif
    </main>

    <!-- Bottom Tab Bar -->
    <nav class="fixed bottom-0 left-0 right-0 bg-[#16213e] border-t border-[#0f3460] z-50" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
        <div class="flex justify-around">
            <a href="{{ route('hero') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x2694;&#xFE0F;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Hero</div>
            </a>
            <a href="{{ route('team') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x1F465;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Team</div>
            </a>
            <a href="{{ route('dashboard') }}" class="flex-1 py-3 text-center text-gray-400 hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x1F5FA;&#xFE0F;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">World</div>
            </a>
            <a href="{{ route('shop') }}" class="flex-1 py-3 text-center text-[#f1c40f]" style="border-top: 3px solid #f1c40f;">
                <div class="text-lg sm:text-xl">&#x1F6D2;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Shop</div>
            </a>
        </div>
    </nav>
</div>
