<div x-data="{ zoom: 1 }">
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

        .city-node { cursor: pointer; transition: transform 0.2s; }
        .city-node:hover { transform: scale(1.05); }
        .city-glow { transition: opacity 0.3s; }
        .city-node:hover .city-glow { opacity: 0.8 !important; }

        /* Animations */
        @keyframes flag-wave { 0%, 100% { transform: skewX(0deg); } 25% { transform: skewX(3deg); } 75% { transform: skewX(-3deg); } }
        .flag-wave { animation: flag-wave 2s ease-in-out infinite; }

        .parchment-frame {
            background: linear-gradient(135deg, #6b4226 0%, #8b5e3c 5%, #6b4226 10%, #8b5e3c 95%, #6b4226 100%);
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }
        .parchment-inner {
            background: radial-gradient(ellipse at 20% 30%, rgba(232,213,183,0.8) 0%, transparent 50%),
                        linear-gradient(180deg, #e8d5b7 0%, #d4b896 40%, #b89b6a 100%);
        }
    </style>

    <div class="parchment-frame w-screen h-screen flex flex-col fixed inset-0 overflow-hidden">
        <div class="parchment-inner flex-1 flex flex-col relative w-full h-full">

            <!-- Title -->
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 z-20 text-center bg-[#5a3a1a] border-2 border-[#c9a227] px-6 py-2 rounded shadow-lg">
                <h1 class="font-medieval text-2xl tracking-wider text-[#f1c40f]" style="text-shadow: 0 2px 4px rgba(0,0,0,0.8);">MCOP QUEST</h1>
                <p class="text-xs font-cinzel text-[#a0875a]">Kingdom of Systems</p>
            </div>

            <!-- Map Container -->
            <div class="flex-1 overflow-auto cursor-grab active:cursor-grabbing relative" x-ref="mapContainer">
                <div :style="'transform: scale(' + zoom + '); transform-origin: center center; transition: transform 0.2s; min-width: 1000px; min-height: 800px; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;'">

                    <svg width="1000" height="800" viewBox="0 0 1000 800" class="mx-auto">
                        <defs>
                            <pattern id="parchTex" patternUnits="userSpaceOnUse" width="200" height="200">
                                <rect width="200" height="200" fill="#d4b896"/>
                                <circle cx="50" cy="50" r="40" fill="#caa87a" opacity="0.15"/>
                            </pattern>
                            <pattern id="waterPat" patternUnits="userSpaceOnUse" width="30" height="30">
                                <rect width="30" height="30" fill="#4a90a4"/>
                                <path d="M0 15 Q7 10 15 15 Q22 20 30 15" stroke="#6bb5cc" stroke-width="1" fill="none" opacity="0.5"/>
                            </pattern>
                        </defs>

                        <!-- Background -->
                        <rect width="1000" height="800" fill="url(#parchTex)"/>

                        <!-- Water/Terrain Decorations -->
                        <ellipse cx="900" cy="200" rx="180" ry="250" fill="url(#waterPat)" opacity="0.6"/>
                        <ellipse cx="50" cy="700" rx="120" ry="150" fill="url(#waterPat)" opacity="0.5"/>
                        <path d="M0 650 Q100 600 200 680 Q300 750 200 800 L0 800 Z" fill="url(#waterPat)" opacity="0.5"/>

                        <!-- Roads (Generic) -->
                        <path d="M310 230 Q400 200 480 260" stroke="#a0875a" stroke-width="6" fill="none" stroke-linecap="round" opacity="0.7"/>
                        <path d="M550 310 Q530 400 460 500" stroke="#a0875a" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.6"/>
                        <path d="M230 310 Q200 400 210 480" stroke="#a0875a" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.7"/>

                        <!-- Nodes Loop -->
                        @foreach($nodes as $key => $node)
                        <g class="city-node" transform="translate({{ $node['x'] }}, {{ $node['y'] }})" onclick="alert('Viewing {{ $node['name'] }} ({{ $node['id'] }})')">

                            <!-- Glow -->
                            <circle cx="0" cy="0" r="50" fill="{{ $node['status_color'] }}" opacity="0.1" class="city-glow"/>

                            @if($node['type'] == 'castle')
                                <!-- Castle Image -->
                                <ellipse cx="0" cy="45" rx="60" ry="15" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/castle_citadel.png') }}" x="-60" y="-50" width="120" height="86" preserveAspectRatio="xMidYMid meet"/>
                            @elseif($node['type'] == 'market')
                                <!-- Market Image -->
                                <ellipse cx="0" cy="40" rx="45" ry="12" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/market_stall.png') }}" x="-45" y="-35" width="90" height="80" preserveAspectRatio="xMidYMid meet"/>
                            @elseif($node['type'] == 'tower')
                                <!-- Tower Image -->
                                <ellipse cx="0" cy="35" rx="25" ry="8" fill="#6b4226" opacity="0.4"/>
                                <image href="{{ asset('images/assets_v5/tower_magic.png') }}" x="-25" y="-50" width="50" height="100" preserveAspectRatio="xMidYMid meet"/>
                            @else
                                <!-- Generic Node -->
                                <circle cx="0" cy="0" r="30" fill="#a0875a"/>
                                <text x="0" y="5" text-anchor="middle" font-size="20">{{ $node['icon'] }}</text>
                            @endif

                            <!-- Labels -->
                            <g transform="translate(0, -90)">
                                <rect x="-40" y="-10" width="80" height="20" rx="10" fill="{{ $node['status_color'] }}33" stroke="{{ $node['status_color'] }}" stroke-width="1.5"/>
                                <text x="0" y="4" text-anchor="middle" fill="{{ $node['status_color'] }}" font-size="10" font-family="Cinzel" font-weight="bold">{{ $node['status_label'] }}</text>
                            </g>

                            <text x="0" y="80" text-anchor="middle" fill="#3a2010" font-family="Cinzel" font-size="14" font-weight="bold">{{ $node['name'] }}</text>
                            <text x="0" y="95" text-anchor="middle" fill="#6b4226" font-size="10" font-family="Cinzel">{{ $node['thai_name'] }}</text>

                            @if($node['is_foggy'])
                                <!-- Fog Overlay -->
                                <circle cx="0" cy="0" r="60" fill="gray" opacity="0.5" style="pointer-events: none;"/>
                            @endif
                        </g>
                        @endforeach

                    </svg>
                </div>
            </div>

            <!-- Controls -->
            <div class="absolute bottom-4 right-4 flex gap-2">
                <button @click="zoom = Math.max(0.5, zoom - 0.2)" class="w-10 h-10 bg-[#3a2010] text-[#c9a227] border border-[#c9a227] rounded font-bold">-</button>
                <button @click="zoom = Math.min(2.0, zoom + 0.2)" class="w-10 h-10 bg-[#3a2010] text-[#c9a227] border border-[#c9a227] rounded font-bold">+</button>
            </div>
        </div>
    </div>
</div>
