<?php

namespace App\Console\Commands;

use App\Concerns\EnumeratesPermissions;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class RoleCreateCommand extends Command
{
    use EnumeratesPermissions;

    protected $signature = 'role:create';

    protected $description = 'Creates a new role';

    public function handle(): int
    {
        $name = text('Name');
        $description = text('Description (optional)');
        $admin = confirm('Administrator role?', false, hint: 'Administrator roles have full access to the system');
        if ($admin) {
            $permissions = [];
        } else {
            $permissions = $this->getPermissions();
        }

        $role = Role::create([
            'name' => $name,
            'description' => $description,
            'admin' => $admin,
        ]);

        foreach ($permissions as $permission) {
            $this->assignPermissionToRole($role, $permission);
        }

        $this->info("Role $role->name successfully created with ID {$role->getKey()}");

        return static::SUCCESS;
    }

    private function getPermissions(): array
    {
        $validPermissions = $this->enumeratePermissions();

        return multiselect('Permissions', $validPermissions);
    }

    private function assignPermissionToRole(Role $role, string $permission): RolePermission
    {
        $permission = explode(':', $permission);

        return $role->permissions()->create([
            'resource' => $permission[0],
            'action' => $permission[1],
        ]);
    }
}
