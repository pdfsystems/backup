<?php

namespace App\Policies;

use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RolePermission $rolePermission): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->admin;
    }

    public function update(User $user, RolePermission $rolePermission): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, RolePermission $rolePermission): bool
    {
        return $this->update($user, $rolePermission);
    }

    public function restore(User $user, RolePermission $rolePermission): bool
    {
        return $this->delete($user, $rolePermission);
    }

    public function forceDelete(User $user, RolePermission $rolePermission): bool
    {
        return $this->delete($user, $rolePermission);
    }
}
