<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class UserCreateTokenCommand extends Command
{
    protected $signature = 'user:create-token';

    protected $description = 'Creates a new API access token for a user';

    public function handle(): int
    {
        $user = null;
        do {
            $input = text('Enter the user ID or email', required: true);
            $user = User::orWhere('id', '=', $input)
                ->orWhere('email', '=', $input)
                ->first();
        } while (empty($user));

        $token = $user->createToken(text('Enter the name of the token', required: true));

        $this->info("Token created successfully: $token->plainTextToken");

        return static::SUCCESS;
    }
}
