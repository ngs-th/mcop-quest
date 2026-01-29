<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\System;

use App\Services\Game\RiskService;

#[Layout('layouts.app')]
class WorldMap extends Component
{
    public function render()
    {
        $riskService = new RiskService();
        $systems = System::with(['flows.tasks'])->get();

        // Decorate systems with Risk Data
        foreach ($systems as $system) {
            $system->is_foggy = $riskService->isSystemFoggy($system);
            $system->risk_level = $riskService->calculateSystemRisk($system);
        }

        return view('livewire.pages.world-map', [
            'systems' => $systems
        ]);
    }
}
