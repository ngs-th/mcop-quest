<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\[Model];

class [ComponentName] extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    #[Locked]
    public int|null $deleteId = null;

    public function delete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function confirmDelete(): void
    {
        [Model]::findOrFail($this->deleteId)?->delete();
        $this->deleteId = null;
    }

    #[Computed]
    public function items(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return [Model]::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.[component-name]')
            ->layout('layouts.app');
    }
}
