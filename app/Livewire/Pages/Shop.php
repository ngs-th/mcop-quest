<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Shop extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $items = [];

    /** @var array<int, string> */
    public array $categories = ['All', 'Boosts', 'Skins', 'Items'];

    public string $selectedCategory = 'All';

    public int $userGold = 2450;

    public int $userGems = 15;

    public int $userLevel = 5;

    public function mount(): void
    {
        $this->loadItems();
    }

    public function filterByCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function purchaseItem(int $itemId): void
    {
        $item = $this->findItem($itemId);

        if ($item === null) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Item not found']);
            return;
        }

        if ($item['owned']) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => 'You already own this item']);
            return;
        }

        if ($this->userLevel < $item['required_level']) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Level too low to purchase this item']);
            return;
        }

        if ($item['currency'] === 'gold' && $this->userGold < $item['price']) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Not enough Gold']);
            return;
        }

        if ($item['currency'] === 'gems' && $this->userGems < $item['price']) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Not enough Gems']);
            return;
        }

        // Deduct currency
        if ($item['currency'] === 'gold') {
            $this->userGold -= $item['price'];
        } else {
            $this->userGems -= $item['price'];
        }

        // Mark as owned
        $this->updateItemOwnership($itemId, true);

        $this->dispatch('notify', ['type' => 'success', 'message' => "Purchased {$item['name']}!"]);
    }

    public function render()
    {
        $filteredItems = $this->getFilteredItems();

        return view('livewire.pages.shop', [
            'filteredItems' => $filteredItems,
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getFilteredItems(): array
    {
        if ($this->selectedCategory === 'All') {
            return $this->items;
        }

        return array_values(array_filter(
            $this->items,
            fn (array $item): bool => $item['category'] === $this->selectedCategory
        ));
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findItem(int $itemId): ?array
    {
        foreach ($this->items as $item) {
            if ($item['id'] === $itemId) {
                return $item;
            }
        }

        return null;
    }

    private function updateItemOwnership(int $itemId, bool $owned): void
    {
        foreach ($this->items as $key => $item) {
            if ($item['id'] === $itemId) {
                $this->items[$key]['owned'] = $owned;
                break;
            }
        }
    }

    private function loadItems(): void
    {
        $this->items = [
            // Helmets
            [
                'id' => 1,
                'name' => 'Basic Helmet',
                'description' => 'Starter protection for new adventurers',
                'icon' => '🪖',
                'category' => 'Skins',
                'rarity' => 'common',
                'price' => 0,
                'currency' => 'gold',
                'required_level' => 1,
                'owned' => true,
                'equipped' => false,
            ],
            [
                'id' => 2,
                'name' => 'Warrior Helm',
                'description' => 'Forged in the fires of battle',
                'icon' => '⛑️',
                'category' => 'Skins',
                'rarity' => 'rare',
                'price' => 500,
                'currency' => 'gold',
                'required_level' => 5,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 3,
                'name' => 'Wizard Hat',
                'description' => 'Enhances magical abilities',
                'icon' => '🎩',
                'category' => 'Skins',
                'rarity' => 'epic',
                'price' => 1200,
                'currency' => 'gold',
                'required_level' => 10,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 4,
                'name' => 'Royal Crown',
                'description' => 'Worn by kings and queens',
                'icon' => '👑',
                'category' => 'Skins',
                'rarity' => 'legendary',
                'price' => 5000,
                'currency' => 'gold',
                'required_level' => 20,
                'owned' => false,
                'equipped' => false,
            ],
            // Weapons
            [
                'id' => 5,
                'name' => 'Basic Sword',
                'description' => 'A trusty blade for beginners',
                'icon' => '🗡️',
                'category' => 'Skins',
                'rarity' => 'common',
                'price' => 0,
                'currency' => 'gold',
                'required_level' => 1,
                'owned' => true,
                'equipped' => true,
            ],
            [
                'id' => 6,
                'name' => 'Fire Sword',
                'description' => 'Burns with eternal flame',
                'icon' => '🔥',
                'category' => 'Skins',
                'rarity' => 'rare',
                'price' => 800,
                'currency' => 'gold',
                'required_level' => 8,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 7,
                'name' => 'Lightning Staff',
                'description' => 'Channels the power of storms',
                'icon' => '⚡',
                'category' => 'Skins',
                'rarity' => 'epic',
                'price' => 1500,
                'currency' => 'gold',
                'required_level' => 12,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 8,
                'name' => 'Legendary Axe',
                'description' => 'A weapon of myth and legend',
                'icon' => '🪓',
                'category' => 'Skins',
                'rarity' => 'legendary',
                'price' => 10000,
                'currency' => 'gold',
                'required_level' => 25,
                'owned' => false,
                'equipped' => false,
            ],
            // Shields
            [
                'id' => 9,
                'name' => 'Wooden Shield',
                'description' => 'Simple but reliable protection',
                'icon' => '🛡️',
                'category' => 'Skins',
                'rarity' => 'common',
                'price' => 0,
                'currency' => 'gold',
                'required_level' => 1,
                'owned' => true,
                'equipped' => true,
            ],
            [
                'id' => 10,
                'name' => 'Iron Shield',
                'description' => 'Reinforced with iron plating',
                'icon' => '🔰',
                'category' => 'Skins',
                'rarity' => 'rare',
                'price' => 700,
                'currency' => 'gold',
                'required_level' => 7,
                'owned' => false,
                'equipped' => false,
            ],
            // Boosts
            [
                'id' => 11,
                'name' => 'XP Boost',
                'description' => 'Double XP for 1 hour',
                'icon' => '⚡',
                'category' => 'Boosts',
                'rarity' => 'rare',
                'price' => 100,
                'currency' => 'gems',
                'required_level' => 1,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 12,
                'name' => 'Gold Boost',
                'description' => 'Double Gold earnings for 1 hour',
                'icon' => '🪙',
                'category' => 'Boosts',
                'rarity' => 'epic',
                'price' => 150,
                'currency' => 'gems',
                'required_level' => 5,
                'owned' => false,
                'equipped' => false,
            ],
            // Items
            [
                'id' => 13,
                'name' => 'Health Potion',
                'description' => 'Restores full health instantly',
                'icon' => '🧪',
                'category' => 'Items',
                'rarity' => 'common',
                'price' => 50,
                'currency' => 'gold',
                'required_level' => 1,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 14,
                'name' => 'Revive Token',
                'description' => 'Continue after defeat',
                'icon' => '🌀',
                'category' => 'Items',
                'rarity' => 'epic',
                'price' => 200,
                'currency' => 'gems',
                'required_level' => 10,
                'owned' => false,
                'equipped' => false,
            ],
            // Special Items
            [
                'id' => 15,
                'name' => 'Dark Theme',
                'description' => 'Switch to dark mode interface',
                'icon' => '🌙',
                'category' => 'Items',
                'rarity' => 'common',
                'price' => 0,
                'currency' => 'gold',
                'required_level' => 1,
                'owned' => true,
                'equipped' => true,
            ],
            [
                'id' => 16,
                'name' => 'Custom Title',
                'description' => 'Show a special title on your profile',
                'icon' => '📛',
                'category' => 'Items',
                'rarity' => 'rare',
                'price' => 2000,
                'currency' => 'gold',
                'required_level' => 15,
                'owned' => false,
                'equipped' => false,
            ],
            [
                'id' => 17,
                'name' => 'Animated Avatar Frame',
                'description' => 'Add a glowing frame around your avatar',
                'icon' => '🖼️',
                'category' => 'Skins',
                'rarity' => 'legendary',
                'price' => 15000,
                'currency' => 'gold',
                'required_level' => 30,
                'owned' => false,
                'equipped' => false,
            ],
        ];
    }
}
