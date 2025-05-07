<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Application $application): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Application $application): bool
    {
        return true;
    }

    public function delete(User $user, Application $application): bool
    {
        return true;
    }

    public function restore(User $user, Application $application): bool
    {
        return true;
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return true;
    }
}
