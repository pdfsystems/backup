<?php

use App\Livewire\ApplicationCreate;
use App\Livewire\ApplicationEdit;
use App\Livewire\ApplicationIndex;
use App\Livewire\Dashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectToRoute('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('applications', ApplicationIndex::class)->name('ui.applications.index');
    Route::get('applications/create', ApplicationCreate::class)->name('ui.applications.create');
    Route::get('applications/{application}/edit', ApplicationEdit::class)->name('ui.applications.edit');
});

require __DIR__.'/auth.php';
