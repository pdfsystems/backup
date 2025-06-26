<?php

namespace Database\Seeders;

use App\Enums\Action;
use App\Models\Backup;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Administrator',
            'description' => 'Full access to the system',
            'admin' => true,
        ]);

        Role::create([
            'name' => 'Backup',
            'description' => 'Only allowed to store new backups',
        ])->permissions()->create([
            'resource' => Backup::class,
            'action' => Action::Create->value,
        ]);

        Role::create([
            'name' => 'Restore',
            'description' => 'Only allowed to restore backups',
        ])->permissions()->create([
            'resource' => Backup::class,
            'action' => Action::Read->value,
        ]);

        Role::create([
            'name' => 'Backup Manager',
            'description' => 'Full access to backups',
        ])->permissions()->create([
            'resource' => Backup::class,
            'action' => Action::All->value,
        ]);
    }
}
