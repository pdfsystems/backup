<?php

namespace App\Console\Commands;

use App\Concerns\EnumeratesPermissions;
use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class UserCreateTokenCommand extends Command
{
    use EnumeratesPermissions;

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
}
