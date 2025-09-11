<?php

namespace App\Livewire;

use App\Models\Application;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ApplicationEdit extends Component
{
    public Application $application;

    #[Validate(['required', 'max:255'])]
    public string $name = '';

    #[Validate(['string', 'url', 'max:255', 'nullable'])]
    public ?string $url = '';

    public function mount(): void
    {
        $this->name = $this->application->name;
        $this->url = $this->application->url;
    }

    public function render(): View
    {
        return view('livewire.application-edit');
    }

    public function save(): void
    {
        $this->application->update($this->validate());

        Flux::toast('Application updated', variant: 'success');
    }
}
