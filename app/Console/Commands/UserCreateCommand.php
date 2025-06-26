<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class UserCreateCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Creates a new user';

    public function handle(): int
    {
        $name = text('Name');
        $email = text('Email');
        $password = password('Password');
        $role = select('Role', $this->getRoleOptions());

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role,
        ]);

        $this->info("User $user->name create with ID {$user->getKey()}");

        return static::SUCCESS;
    }

    private function getRoleOptions(): array
    {
        return Role::orderBy('name')->get()->mapWithKeys(function (Role $role) {
            return [$role->getKey() => $role->name];
        })->toArray();
    }
}
