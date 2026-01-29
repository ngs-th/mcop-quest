<?php

namespace App\Services\Game;

use App\Models\System;
use App\Models\Flow;

class RiskService
{
    /**
     * Determine if a System (City) is under "Fog of War".
     * Fog of War exists if Requirements (Design/AC) are not 100% clear.
     */
    public function isSystemFoggy(System $system): bool
    {
        // If any Flow has < 100% Design or AC, the System is foggy.
        foreach ($system->flows as $flow) {
            if ($flow->hp_design < 100 || $flow->hp_ac < 100) {
                return true;
            }
        }
        return false;
    }

    /**
     * Calculate the Risk Level of a System based on incomplete tasks vs blocking bugs.
     * Returns: 'safe', 'warning', 'critical'
     */
    public function calculateSystemRisk(System $system): string
    {
        // Logic: 
        // Critical: If any critical bugs exist OR progress is stalled (> 50% flows blocked).
        // Warning: If some bugs exist.
        // Safe: No bugs, steady progress.

        // Simple mock logic for Phase 2:
        if ($system->flows->count() === 0) return 'safe';

        $avgHealth = $system->flows->avg(fn($f) => 
            ($f->hp_api + $f->hp_fe + $f->hp_testing) / 3
        );

        if ($avgHealth < 20) return 'critical';
        if ($avgHealth < 50) return 'warning';
        return 'safe';
    }
}
