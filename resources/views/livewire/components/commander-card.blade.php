<div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.01] transition-all duration-200">
    <!-- Card Header -->
    <div class="p-4 bg-gray-900/50 border-b border-gray-700 flex justify-between items-start">
        <div>
            <h3 class="font-bold text-lg text-gray-100">{{ $flow->name }}</h3>
            @if($flow->group)
                <span class="text-xs bg-indigo-900 text-indigo-300 px-2 py-0.5 rounded">{{ $flow->group }}</span>
            @endif
        </div>
        <div class="text-right text-xs text-gray-400">
            @if($flow->assignee)
                <div class="flex items-center gap-1 justify-end">
                    <span>⚔️</span> {{ $flow->assignee }}
                </div>
            @endif
            <div class="mt-1">ID: {{ $flow->id }}</div>
        </div>
    </div>

    <!-- 6 HP Bars -->
    <div class="p-4 grid grid-cols-2 gap-3 text-xs border-b border-gray-700 bg-gray-800">
        <!-- Design -->
        <div class="space-y-1">
            <div class="flex justify-between text-purple-400"><span>Design</span> <span>{{ $flow->hp_design }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500 transition-all duration-500" style="width: {{ $flow->hp_design }}%"></div>
            </div>
        </div>
        <!-- AC -->
        <div class="space-y-1">
            <div class="flex justify-between text-blue-400"><span>AC</span> <span>{{ $flow->hp_ac }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 transition-all duration-500" style="width: {{ $flow->hp_ac }}%"></div>
            </div>
        </div>
        <!-- API -->
        <div class="space-y-1">
            <div class="flex justify-between text-green-400"><span>API</span> <span>{{ $flow->hp_api }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 transition-all duration-500" style="width: {{ $flow->hp_api }}%"></div>
            </div>
        </div>
        <!-- FE/App -->
        <div class="space-y-1">
            <div class="flex justify-between text-orange-400"><span>FE/App</span> <span>{{ $flow->hp_fe }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-orange-500 transition-all duration-500" style="width: {{ $flow->hp_fe }}%"></div>
            </div>
        </div>
        <!-- Testing -->
        <div class="space-y-1">
            <div class="flex justify-between text-teal-400"><span>Testing</span> <span>{{ $flow->hp_testing }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-teal-500 transition-all duration-500" style="width: {{ $flow->hp_testing }}%"></div>
            </div>
        </div>
        <!-- UAT -->
        <div class="space-y-1">
            <div class="flex justify-between text-emerald-400"><span>UAT</span> <span>{{ $flow->hp_uat }}%</span></div>
            <div class="h-1.5 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 transition-all duration-500" style="width: {{ $flow->hp_uat }}%"></div>
            </div>
        </div>
    </div>

    <!-- Minions (Tasks) -->
    <div class="p-4" x-data="{ open: false }">
        <button @click="open = !open" class="w-full text-left text-xs text-gray-400 hover:text-white flex justify-between items-center mb-2">
            <span>Minions (Tasks) - {{ $flow->tasks->count() }}</span>
            <span x-text="open ? '▼' : '▶'"></span>
        </button>
        
        <div x-show="open" class="space-y-2 mt-2" x-transition>
            @foreach($flow->tasks as $task)
                <div class="flex items-center justify-between bg-gray-900 p-2 rounded border {{ $task->status == 'done' ? 'border-gray-800 opacity-50' : 'border-gray-600' }}">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                {{ $task->type == 'UI' ? 'bg-purple-900 text-purple-300' : '' }}
                                {{ $task->type == 'API' ? 'bg-green-900 text-green-300' : '' }}
                                {{ $task->type == 'FE' ? 'bg-orange-900 text-orange-300' : '' }}
                            ">{{ $task->type }}</span>
                            <span class="text-sm truncate {{ $task->status == 'done' ? 'line-through text-gray-500' : 'text-gray-200' }}">
                                {{ $task->title }}
                            </span>
                        </div>
                        <div class="text-[10px] text-gray-500 mt-0.5 ml-1">
                            {{ $task->assignee }} • {{ ucfirst($task->status) }}
                        </div>
                    </div>
                    
                </div>
            @endforeach
            
            @if($flow->tasks->isEmpty())
                <div class="text-xs text-gray-600 italic text-center py-2">No active minions detected.</div>
            @endif
        </div>
    </div>
</div>
