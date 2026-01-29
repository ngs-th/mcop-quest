<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Flow;
use App\Models\Task;
use App\Services\Game\GameService;

class CommanderCard extends Component
{
    public Flow $flow;

    public function render()
    {
        return view('livewire.components.commander-card');
    }
}
