<?php

namespace App\Policies;

use App\Enums\Action;
use App\Models\Backup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BackupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Backup::class, Action::Read);
    }

    public function view(User $user, Backup $backup): bool
    {
        return $user->hasPermission($backup, Action::Read);
    }

    public function download(User $user, Backup $backup): bool
    {
        return $this->view($user, $backup);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Backup::class, Action::Create);
    }

    public function update(User $user, Backup $backup): bool
    {
        return $user->hasPermission($backup, Action::Update);
    }

    public function delete(User $user, Backup $backup): bool
    {
        return $user->hasPermission($backup, Action::Delete);
    }

    public function restore(User $user, Backup $backup): bool
    {
        return $user->hasPermission($backup, Action::Restore);
    }

    public function forceDelete(User $user, Backup $backup): bool
    {
        return $user->hasPermission($backup, Action::ForceDelete);
    }
}
