<?php

namespace App\Livewire;

use App\Models\Backup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class BackupIndex extends Component
{
    use WithPagination;

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public function render(): View
    {
        return view('livewire.backup-index');
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
    public function backups(): LengthAwarePaginator
    {
        $this->authorize('view-any', Backup::class);

        $builder = Backup::query();

        if (auth()->user()->role?->admin !== true) {
            $builder->where('user_id', auth()->user()->getKey());
        }

        $builder->orderBy($this->sortBy, $this->sortDirection);

        return $builder->paginate();
    }
}
