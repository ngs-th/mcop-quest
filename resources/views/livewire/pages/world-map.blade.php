<div x-data="{ zoom: 1, hoveredNode: null }">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=MedievalSharp&family=Inter:wght@400;500;600;700&display=swap');

        .font-medieval { font-family: 'MedievalSharp', 'Cinzel', serif; }
        .font-cinzel { font-family: 'Cinzel', serif; }

        :root {
            --parchment: #d4b896;
            --hp-full: #2ecc71;
            --hp-stable: #3498db;
            --hp-medium: #f1c40f;
            --hp-low: #e74c3c;
            --hp-fog: #95a5a6;
        }

        .city-node { cursor: pointer; transition: transform 0.3s, filter 0.3s; }
        .city-node:hover { transform: scale(1.08); filter: brightness(1.1); }
        .city-glow { transition: opacity 0.3s, r 0.3s; }
        .city-node:hover .city-glow { opacity: 0.9 !important; }

        /* Animations */
        @keyframes flag-wave { 0%, 100% { transform: skewX(0deg); } 25% { transform: skewX(3deg); } 75% { transform: skewX(-3deg); } }
        .flag-wave { animation: flag-wave 2s ease-in-out infinite; }

        @keyframes fog-drift {
            0%, 100% { opacity: 0.4; transform: translateX(0); }
            50% { opacity: 0.6; transform: translateX(5px); }
        }
        .fog-animate { animation: fog-drift 4s ease-in-out infinite; }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 0.25; }
        }
        .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }

        @keyframes torch-flicker {
            0%, 100% { opacity: 0.6; }
            25% { opacity: 0.8; }
            50% { opacity: 0.5; }
            75% { opacity: 0.7; }
        }
        .torch-flicker { animation: torch-flicker 1.5s ease-in-out infinite; }

        .parchment-frame {
            background: linear-gradient(135deg, #6b4226 0%, #8b5e3c 5%, #6b4226 10%, #8b5e3c 95%, #6b4226 100%);
            box-shadow: inset 0 0 30px rgba(0,0,0,0.6);
        }
        .parchment-inner {
            background: radial-gradient(ellipse at 20% 30%, rgba(232,213,183,0.8) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 70%, rgba(200,170,130,0.3) 0%, transparent 40%),
                        linear-gradient(180deg, #e8d5b7 0%, #d4b896 40%, #b89b6a 100%);
        }

        /* Tooltip */
        .city-tooltip {
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .city-node:hover .city-tooltip {
            opacity: 1;
        }
    </style>

    <div class="parchment-frame w-screen h-screen flex flex-col fixed inset-0 overflow-hidden">
        <div class="parchment-inner flex-1 flex flex-col relative w-full h-full">

            <!-- Title -->
            <div class="absolute top-2 sm:top-4 left-1/2 transform -translate-x-1/2 z-20 text-center bg-[#5a3a1a] border-2 border-[#c9a227] px-3 sm:px-6 py-1.5 sm:py-2 rounded shadow-lg" style="box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                <h1 class="font-medieval text-lg sm:text-2xl tracking-wider text-[#f1c40f]" style="text-shadow: 0 2px 4px rgba(0,0,0,0.8);">MCOP QUEST</h1>
                <p class="text-[10px] sm:text-xs font-cinzel text-[#a0875a]">Kingdom of Systems</p>
            </div>

            <!-- Map Legend (collapsible on mobile) -->
            <div x-data="{ legendOpen: window.innerWidth >= 640 }" class="absolute top-2 sm:top-4 left-2 sm:left-4 z-20">
                <button @click="legendOpen = !legendOpen" class="sm:hidden bg-[#5a3a1a]/90 border border-[#c9a227]/50 px-2 py-1.5 rounded text-[#c9a227] text-xs font-cinzel" style="backdrop-filter: blur(4px);">
                    <span x-text="legendOpen ? '✕' : '📋'"></span>
                </button>
                <div x-show="legendOpen" x-transition class="bg-[#5a3a1a]/90 border border-[#c9a227]/50 px-2 sm:px-3 py-1.5 sm:py-2 rounded text-xs font-cinzel space-y-1 mt-1 sm:mt-0" style="backdrop-filter: blur(4px);">
                    <p class="text-[#c9a227] font-bold text-[10px] sm:text-[11px] uppercase tracking-wider mb-1">Status</p>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#2ecc71]"></span><span class="text-[#d4b896] text-[11px] sm:text-xs">Full HP</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#3498db]"></span><span class="text-[#d4b896] text-[11px] sm:text-xs">Stable</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#f1c40f]"></span><span class="text-[#d4b896] text-[11px] sm:text-xs">Medium</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#e74c3c]"></span><span class="text-[#d4b896] text-[11px] sm:text-xs">Low HP</span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-[#95a5a6]"></span><span class="text-[#d4b896] text-[11px] sm:text-xs">Fog of War</span></div>
                </div>
            </div>

            <!-- Map Container -->
            <div class="flex-1 overflow-auto cursor-grab active:cursor-grabbing relative" x-ref="mapContainer">
                <div :style="'transform: scale(' + zoom + '); transform-origin: center center; transition: transform 0.2s; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;'">

                    <svg viewBox="0 0 1000 800" class="mx-auto w-full h-full" style="min-width: 600px; max-width: 1200px;" preserveAspectRatio="xMidYMid meet">
                        <defs>
                            <pattern id="parchTex" patternUnits="userSpaceOnUse" width="200" height="200">
                                <rect width="200" height="200" fill="#d4b896"/>
                                <circle cx="50" cy="50" r="40" fill="#caa87a" opacity="0.15"/>
                                <circle cx="150" cy="120" r="25" fill="#b8956a" opacity="0.08"/>
                            </pattern>
                            <pattern id="waterPat" patternUnits="userSpaceOnUse" width="30" height="30">
                                <rect width="30" height="30" fill="#4a90a4"/>
                                <path d="M0 15 Q7 10 15 15 Q22 20 30 15" stroke="#6bb5cc" stroke-width="1" fill="none" opacity="0.5"/>
                            </pattern>
                            <!-- Tree symbols -->
                            <symbol id="tree-pine" viewBox="0 0 20 30">
                                <polygon points="10,2 3,15 17,15" fill="#3a6b35" opacity="0.7"/>
                                <polygon points="10,8 5,20 15,20" fill="#2d5a27" opacity="0.7"/>
                                <rect x="8" y="20" width="4" height="6" fill="#5d4e37" opacity="0.6"/>
                            </symbol>
                            <symbol id="mountain" viewBox="0 0 40 30">
                                <polygon points="20,2 0,30 40,30" fill="#8b7355" opacity="0.4"/>
                                <polygon points="20,2 15,12 25,12" fill="#a0937a" opacity="0.3"/>
                            </symbol>
                            <!-- Fog filter -->
                            <filter id="fogFilter" x="-50%" y="-50%" width="200%" height="200%">
                                <feTurbulence type="fractalNoise" baseFrequency="0.03" numOctaves="4" result="noise"/>
                                <feColorMatrix type="saturate" values="0" in="noise" result="grayNoise"/>
                                <feComponentTransfer in="grayNoise" result="alphaMap">
                                    <feFuncA type="linear" slope="0.6" intercept="0"/>
                                </feComponentTransfer>
                                <feComposite in="SourceGraphic" in2="alphaMap" operator="in"/>
                            </filter>
                        </defs>

                        <!-- Background -->
                        <rect width="1000" height="800" fill="url(#parchTex)"/>

                        <!-- Water/Terrain -->
                        <ellipse cx="900" cy="200" rx="180" ry="250" fill="url(#waterPat)" opacity="0.6"/>
                        <ellipse cx="50" cy="700" rx="120" ry="150" fill="url(#waterPat)" opacity="0.5"/>
                        <path d="M0 650 Q100 600 200 680 Q300 750 200 800 L0 800 Z" fill="url(#waterPat)" opacity="0.5"/>

                        <!-- Decorative Trees -->
                        <use href="#tree-pine" x="100" y="120" width="16" height="24"/>
                        <use href="#tree-pine" x="120" y="135" width="14" height="21"/>
                        <use href="#tree-pine" x="85" y="140" width="12" height="18"/>
                        <use href="#tree-pine" x="600" y="580" width="16" height="24"/>
                        <use href="#tree-pine" x="620" y="600" width="14" height="21"/>
                        <use href="#tree-pine" x="580" y="610" width="12" height="18"/>
                        <use href="#tree-pine" x="800" y="520" width="15" height="22"/>
                        <use href="#tree-pine" x="820" y="540" width="13" height="19"/>
                        <use href="#tree-pine" x="350" y="380" width="12" height="18"/>
                        <use href="#tree-pine" x="370" y="400" width="10" height="15"/>

                        <!-- Decorative Mountains -->
                        <use href="#mountain" x="700" y="100" width="50" height="38"/>
                        <use href="#mountain" x="730" y="115" width="40" height="30"/>
                        <use href="#mountain" x="100" y="350" width="45" height="34"/>

                        <!-- Roads -->
                        <path d="M310 230 Q400 200 480 260" stroke="#a0875a" stroke-width="6" fill="none" stroke-linecap="round" opacity="0.7" stroke-dasharray="12 4"/>
                        <path d="M550 310 Q530 400 460 500" stroke="#a0875a" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.6" stroke-dasharray="10 4"/>
                        <path d="M230 310 Q200 400 210 480" stroke="#a0875a" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.7" stroke-dasharray="10 4"/>
                        <path d="M600 280 Q680 300 700 380" stroke="#a0875a" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.6" stroke-dasharray="10 4"/>
                        <path d="M260 580 Q300 620 350 650" stroke="#a0875a" stroke-width="4" fill="none" stroke-linecap="round" opacity="0.5" stroke-dasharray="8 4"/>

                        <!-- Nodes Loop -->
                        @foreach($nodes as $key => $node)
                        <a href="{{ route('city.detail', ['id' => $node['id']]) }}" style="text-decoration: none;">
                        <g class="city-node" transform="translate({{ $node['x'] }}, {{ $node['y'] }})">

                            <!-- Ambient Glow -->
                            <circle cx="0" cy="0" r="55" fill="{{ $node['status_color'] }}" opacity="0.08" class="pulse-glow"/>
                            <circle cx="0" cy="0" r="45" fill="{{ $node['status_color'] }}" opacity="0.12" class="city-glow"/>

                            @if($node['type'] == 'castle')
                                <ellipse cx="0" cy="45" rx="60" ry="15" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/castle_citadel.png') }}" x="-60" y="-50" width="120" height="86" preserveAspectRatio="xMidYMid meet"/>
                            @elseif($node['type'] == 'market')
                                <ellipse cx="0" cy="40" rx="45" ry="12" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/market_stall.png') }}" x="-45" y="-35" width="90" height="80" preserveAspectRatio="xMidYMid meet"/>
                            @elseif($node['type'] == 'tower')
                                <ellipse cx="0" cy="35" rx="25" ry="8" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/tower_magic.png') }}" x="-25" y="-50" width="50" height="100" preserveAspectRatio="xMidYMid meet"/>
                            @else
                                <ellipse cx="0" cy="35" rx="35" ry="10" fill="#6b4226" opacity="0.3"/>
                                <circle cx="0" cy="0" r="28" fill="#8b6b4a" stroke="#c9a227" stroke-width="2"/>
                                <text x="0" y="6" text-anchor="middle" font-size="22">{{ $node['icon'] }}</text>
                            @endif

                            <!-- Status Label -->
                            <g transform="translate(0, -90)">
                                <rect x="-45" y="-12" width="90" height="24" rx="12" fill="{{ $node['status_color'] }}22" stroke="{{ $node['status_color'] }}" stroke-width="1.5"/>
                                <text x="0" y="4" text-anchor="middle" fill="{{ $node['status_color'] }}" font-size="9" font-family="Cinzel" font-weight="bold">{{ $node['status_label'] }}</text>
                            </g>

                            <!-- HP Bar -->
                            <g transform="translate(0, 60)">
                                <rect x="-30" y="0" width="60" height="6" rx="3" fill="#3a2010" opacity="0.5"/>
                                <rect x="-30" y="0" width="{{ max(2, 60 * $node['hp_percent'] / 100) }}" height="6" rx="3" fill="{{ $node['status_color'] }}"/>
                            </g>

                            <!-- Name Labels -->
                            <text x="0" y="80" text-anchor="middle" fill="#3a2010" font-family="Cinzel" font-size="13" font-weight="bold">{{ $node['name'] }}</text>
                            <text x="0" y="93" text-anchor="middle" fill="#6b4226" font-size="9" font-family="Cinzel">{{ $node['thai_name'] }}</text>

                            @if($node['is_foggy'])
                                <!-- Fog Overlay -->
                                <g class="fog-animate" style="pointer-events: none;">
                                    <ellipse cx="-15" cy="-10" rx="45" ry="35" fill="#7a7a7a" opacity="0.4" filter="url(#fogFilter)"/>
                                    <ellipse cx="15" cy="10" rx="40" ry="30" fill="#8a8a8a" opacity="0.35"/>
                                    <ellipse cx="0" cy="0" rx="50" ry="40" fill="#6a6a6a" opacity="0.3"/>
                                </g>
                            @endif
                        </g>
                        </a>
                        @endforeach

                    </svg>
                </div>
            </div>

            <!-- Zoom Controls -->
            <div class="absolute bottom-24 sm:bottom-20 right-2 sm:right-4 flex flex-col gap-1.5 sm:gap-2 z-20">
                <button @click="zoom = Math.min(2.0, zoom + 0.2)" class="w-9 h-9 sm:w-10 sm:h-10 bg-[#3a2010] text-[#c9a227] border border-[#c9a227] rounded-lg font-bold shadow-lg hover:bg-[#4a3020] transition-colors text-sm sm:text-base">+</button>
                <button @click="zoom = Math.max(0.5, zoom - 0.2)" class="w-9 h-9 sm:w-10 sm:h-10 bg-[#3a2010] text-[#c9a227] border border-[#c9a227] rounded-lg font-bold shadow-lg hover:bg-[#4a3020] transition-colors text-sm sm:text-base">-</button>
                <button @click="zoom = 1" class="w-9 h-9 sm:w-10 sm:h-10 bg-[#3a2010] text-[#c9a227] border border-[#c9a227] rounded-lg text-[10px] sm:text-xs shadow-lg hover:bg-[#4a3020] transition-colors">1:1</button>
            </div>
        </div>
    </div>

    <!-- Bottom Tab Bar -->
    <nav class="fixed bottom-0 left-0 right-0 bg-[#3a2010] border-t border-[#c9a227]/30 z-50" style="padding-bottom: env(safe-area-inset-bottom, 0px);">
        <div class="flex justify-around">
            <a href="{{ route('hero') }}" class="flex-1 py-3 text-center text-[#a0875a] hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x2694;&#xFE0F;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Hero</div>
            </a>
            <a href="{{ route('team') }}" class="flex-1 py-3 text-center text-[#a0875a] hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x1F465;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Team</div>
            </a>
            <a href="{{ route('dashboard') }}" class="flex-1 py-3 text-center text-[#f1c40f]" style="border-top: 3px solid #f1c40f;">
                <div class="text-lg sm:text-xl">&#x1F5FA;&#xFE0F;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">World</div>
            </a>
            <a href="{{ route('shop') }}" class="flex-1 py-3 text-center text-[#a0875a] hover:text-[#f1c40f] transition-colors">
                <div class="text-lg sm:text-xl">&#x1F6D2;</div>
                <div class="text-[10px] sm:text-xs mt-1 font-cinzel">Shop</div>
            </a>
        </div>
    </nav>
</div>
