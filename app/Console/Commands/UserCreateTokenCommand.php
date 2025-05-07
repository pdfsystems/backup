<?php

namespace App\Console\Commands;

use App\Enums\Action;
use App\Models\Application;
use App\Models\Backup;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class UserCreateTokenCommand extends Command
{
    protected $signature = 'user:create-token';

    protected $description = 'Creates a new API access token for a user';

    public function handle(): int
    {
        do {
            $input = text('Enter the user ID or email', required: true);
            $user = User::orWhere('id', '=', $input)
                ->orWhere('email', '=', $input)
                ->first();
        } while (empty($user));

        $token = $user->createToken(
            text('Enter the name of the token', required: true),
            $this->getAbilities()
        );

        $this->info("Token created successfully: $token->plainTextToken");

        return static::SUCCESS;
    }

    private function getAbilities(): array
    {
        $validPermissions = $this->enumeratePermissions();

        return multiselect('Select the permissions for the token', $validPermissions, default: ['*']);
    }

    private function enumeratePermissions(): array
    {
        return array_merge([
            '*',
        ], $this->enumerateModelPermissions());
    }

    private function enumerateModelPermissions(): array
    {
        $permissions = [];
        foreach ($this->enumerateGuardedModels() as $modelClass) {
            $permissions = array_merge($permissions, $this->getModelPermissions($modelClass));
        }
        return $permissions;
    }

    private function getModelPermissions(string $modelClass): array
    {
        return array_map(fn (string $permission) => "$modelClass:$permission", array_column(Action::cases(), 'value'));
    }

    private function enumerateGuardedModels(): array
    {
        return [
            Application::class,
            Backup::class
        ];
    }
}
