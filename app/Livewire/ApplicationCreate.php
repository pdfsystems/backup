<?php

namespace App\Livewire;

use App\Models\Application;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ApplicationCreate extends Component
{
    #[Validate(['required', 'max:255'])]
    public string $name = '';

    #[Validate(['string', 'url', 'max:255', 'nullable'])]
    public string $url = '';

    public function render(): View
    {
        return view('livewire.application-create');
    }

    public function create(): void
    {
        $this->authorize('create', Application::class);

        $this->redirectRoute('ui.applications.edit', Application::create($this->validate()));
    }
}
