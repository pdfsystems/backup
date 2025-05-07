<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Role $role): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->admin;
    }

    public function update(User $user, Role $role): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Role $role): bool
    {
        return $this->update($user, $role);
    }

    public function restore(User $user, Role $role): bool
    {
        return $this->delete($user, $role);
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return $this->delete($user, $role);
    }
}
