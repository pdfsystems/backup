<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;

trait AuthenticatedTest
{
    protected ?User $admin;
    protected ?User $noAccess;

    protected ?string $adminToken;
    protected ?string $noAccessToken;

    public function setUpAuthenticatedTest(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Administrator', 'admin' => true]);
        $noAccessRole = Role::create(['name' => 'No Access']);

        // Create users
        $this->admin = User::factory()->withRole($adminRole)->create();
        $this->noAccess = User::factory()->withRole($noAccessRole)->create();

        // Create personal access tokens
        $adminToken = $this->admin->createToken('Test Token');
        $noAccessToken = $this->noAccess->createToken('Test Token');

        // Store tokens
        $this->adminToken = substr($adminToken->plainTextToken, strpos($adminToken->plainTextToken, '|') + 1);
        $this->noAccessToken = substr($noAccessToken->plainTextToken, strpos($noAccessToken->plainTextToken, '|') + 1);
    }
}
