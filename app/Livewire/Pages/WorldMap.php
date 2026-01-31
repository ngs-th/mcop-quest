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

        // 1. Define Visual Nodes (Configuration)
        $visualNodes = [
            'member_city' => [
                'id' => 1, 'name' => 'Member City', 'thai_name' => 'ระบบสมาชิก', 
                'x' => 230, 'y' => 220, 'icon' => '♛', 'type' => 'castle',
                'systems' => ['ระบบสมาชิก', 'ระบบผู้ดูแลระบบ', 'เว็บไซต์สำหรับสมาชิก', 'ระบบบริการสมาชิกผ่านมือถือ', 'ระบบบุคลากร']
            ],
            'product_city' => [
                'id' => 2, 'name' => 'Product City', 'thai_name' => 'ระบบสินค้า', 
                'x' => 550, 'y' => 250, 'icon' => '$', 'type' => 'market',
                'systems' => ['ระบบเงินฝาก', 'ระบบเงินกู้', 'ระบบทุนเรือนหุ้น', 'ระบบลงทุน']
            ],
            'task_tower' => [
                'id' => 3, 'name' => 'Support Tower', 'thai_name' => 'ระบบสนับสนุน', 
                'x' => 420, 'y' => 170, 'icon' => '🛠️', 'type' => 'tower',
                'systems' => ['ระบบสำรองข้อมูล', 'ระบบสนับสนุน']
            ],
            'finance_fortress' => [
                'id' => 7, 'name' => 'Payment Fortress', 'thai_name' => 'ระบบการเงิน', 
                'x' => 750, 'y' => 430, 'icon' => '💰', 'type' => 'fortress',
                'systems' => ['ระบบการเงิน', 'ระบบบัญชี', 'ระบบตั๋วสัญญาใช้เงิน', 'ระบบเงินปันผลและเฉลี่ยคืน']
            ],
            'analytics_lab' => [
                'id' => 5, 'name' => 'Analytics Lab', 'thai_name' => 'ระบบวิเคราะห์', 
                'x' => 430, 'y' => 520, 'icon' => '⚗️', 'type' => 'lab',
                'systems' => ['ระบบประมวลผล/วิเคราะห์', 'ระบบรายงาน']
            ],
            'notification_tower' => [
                'id' => 4, 'name' => 'Digital Tower', 'thai_name' => 'ระบบสารสนเทศ', 
                'x' => 200, 'y' => 500, 'icon' => '📡', 'type' => 'tower_bell',
                'systems' => ['ระบบสารสนเทศเพื่อการบริหาร', 'ระบบ ATM Online']
            ],
            'commons' => [
                'id' => 6, 'name' => 'Welfare Commons', 'thai_name' => 'ระบบสวัสดิการ', 
                'x' => 320, 'y' => 670, 'icon' => '🤝', 'type' => 'village',
                'systems' => ['ระบบสวัสดิการ']
            ],
            'bug_bastion' => [
                'id' => 8, 'name' => 'Partner Bastion', 'thai_name' => 'ระบบคู่ค้า', 
                'x' => 680, 'y' => 300, 'icon' => '👹', 'type' => 'bastion',
                'systems' => ['ระบบคู่ค้า']
            ],
        ];

        // 2. Aggregate Data for each Node
        foreach ($visualNodes as $key => &$node) {
            $nodeSystems = $systems->whereIn('name', $node['systems']);
            
            // Calculate Aggregate HP/Status
            // Simple logic: Average of all flows in these systems
            $totalFlows = 0;
            $totalHP = 0;
            $isFoggy = false;

            foreach ($nodeSystems as $sys) {
                if ($riskService->isSystemFoggy($sys)) $isFoggy = true;
                foreach ($sys->flows as $flow) {
                    $totalFlows++;
                    $totalHP += ($flow->hp_design + $flow->hp_api + $flow->hp_fe) / 3;
                }
            }

            $avgHP = $totalFlows > 0 ? $totalHP / $totalFlows : 100;
            
            // Determine Status Label
            $node['hp_percent'] = $avgHP;
            $node['is_foggy'] = $isFoggy;
            $node['status_label'] = $this->getStatusLabel($avgHP, $isFoggy);
            $node['status_color'] = $this->getStatusColor($avgHP, $isFoggy);
        }

        return view('livewire.pages.world-map', [
            'nodes' => $visualNodes
        ]);
    }

    private function getStatusLabel($hp, $isFoggy) {
        if ($isFoggy) return 'Fog of War';
        if ($hp >= 90) return 'Health: Full';
        if ($hp >= 60) return 'Health: Stable';
        if ($hp >= 30) return 'Health: Medium';
        return 'Health: Low';
    }

    private function getStatusColor($hp, $isFoggy) {
        if ($isFoggy) return '#95a5a6'; // gray
        if ($hp >= 90) return '#2ecc71'; // green
        if ($hp >= 60) return '#3498db'; // blue
        if ($hp >= 30) return '#f1c40f'; // yellow
        return '#e74c3c'; // red
    }
}
