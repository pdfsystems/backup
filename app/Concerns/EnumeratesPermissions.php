<?php

namespace App\Concerns;

use App\Enums\Action;
use App\Models\Application;
use App\Models\Backup;

trait EnumeratesPermissions
{
    protected function enumeratePermissions(): array
    {
        return array_merge([
            '*',
        ], $this->enumerateModelPermissions());
    }

    protected function enumerateModelPermissions(): array
    {
        $permissions = [];
        foreach ($this->enumerateGuardedModels() as $modelClass) {
            $permissions = array_merge($permissions, $this->getModelPermissions($modelClass));
        }

        return $permissions;
    }

    protected function getModelPermissions(string $modelClass): array
    {
        return array_map(fn (string $permission) => "$modelClass:$permission", array_column(Action::cases(), 'value'));
    }

    protected function enumerateGuardedModels(): array
    {
        return [
            Application::class,
            Backup::class,
        ];
    }
}
