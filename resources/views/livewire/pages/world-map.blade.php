<div class="py-12 bg-gray-900 min-h-screen text-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-yellow-500 tracking-wider">MCOP QUEST</h1>
            <p class="text-gray-400">World Map - Phase 1 Prototype</p>
        </div>

        @foreach($systems as $system)
            <div class="mb-12">
                <!-- City Header -->
                <div class="border-b border-gray-700 pb-4 mb-6 flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-blue-400">
                            🏰 {{ $system->name }}
                        </h2>
                        <div class="text-sm text-gray-500">City HP: {{ $system->city_hp }}/{{ $system->city_max_hp }}</div>
                    </div>
                    <div class="bg-gray-800 rounded px-3 py-1 text-xs">System ID: {{ $system->id }}</div>
                </div>

                <!-- Commanders Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($system->flows as $flow)
                        <livewire:components.commander-card :flow="$flow" wire:key="flow-{{ $flow->id }}" />
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($systems->isEmpty())
            <div class="text-center py-20 bg-gray-800 rounded-lg opacity-50">
                <p>No Cities found. Please run the Seeders.</p>
                <div class="mt-4 font-mono text-sm text-yellow-600">php artisan db:seed --class=PrototypeSeeder</div>
            </div>
        @endif

    </div>
</div>
