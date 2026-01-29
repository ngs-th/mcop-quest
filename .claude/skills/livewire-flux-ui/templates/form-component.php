<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use App\Services\[Model]Service;

class [ComponentName] extends Component
{
    #[Validate('required|min:3|max:255')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    public bool $showModal = false;

    public function save(): void
    {
        $this->validate();

        app([Model]Service::class)->create($this->only(['name', 'email']));

        session()->flash('status', '[Model] created successfully!');
        $this->reset();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.[component-name]')
            ->layout('layouts.app');
    }
}
