<?php

namespace App\Livewire;

use App\Models\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationIndex extends Component
{
    use WithPagination;

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public function render(): View
    {
        return view('livewire.application-index');
    }

    public function sort(string $by): void
    {
        if ($this->sortBy === $by) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $by;
            $this->reset('sortDirection');
        }
    }

    #[Computed]
    public function applications(): LengthAwarePaginator
    {
        $this->authorize('view-any', Application::class);

        $builder = Application::query();

        if (auth()->user()->role?->admin !== true) {
            $builder->where('user_id', auth()->user()->getKey());
        }

        $builder->orderBy($this->sortBy, $this->sortDirection);

        return $builder->paginate();
    }
}
