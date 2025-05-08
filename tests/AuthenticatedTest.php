<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;

trait AuthenticatedTest
{
    protected ?User $user;

    protected ?string $token;

    public function setUpAuthenticatedTest(): void
    {
        $admin = Role::create(['name' => 'Administrator', 'admin' => true]);
        $this->user = User::factory()->withRole($admin)->create();
        $token = $this->user->createToken('Test Token');
        $this->token = substr($token->plainTextToken, strpos($token->plainTextToken, '|') + 1);
    }
}
