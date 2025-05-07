<?php

namespace Database\Factories;

use App\Enums\Action;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolePermissionFactory extends Factory
{
    protected $model = RolePermission::class;

    public function definition(): array
    {
        return [
            'role_id' => Role::factory(),
            'resource' => $this->faker->word(),
            'action' => $this->faker->randomElement(array_column(Action::cases(), 'value')),
        ];
    }
}
