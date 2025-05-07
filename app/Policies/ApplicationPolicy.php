<?php

namespace App\Policies;

use App\Enums\Action;
use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Application::class, Action::Read);
    }

    public function view(User $user, Application $application): bool
    {
        return $user->hasPermission($application, Action::Read);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Application::class, Action::Create);
    }

    public function update(User $user, Application $application): bool
    {
        return $user->hasPermission($application, Action::Update);
    }

    public function delete(User $user, Application $application): bool
    {
        return $user->hasPermission($application, Action::Delete);
    }

    public function restore(User $user, Application $application): bool
    {
        return $user->hasPermission($application, Action::Restore);
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return $user->hasPermission($application, Action::ForceDelete);
    }
}
