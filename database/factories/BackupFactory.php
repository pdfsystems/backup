<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Backup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BackupFactory extends Factory
{
    protected $model = Backup::class;

    public function definition(): array
    {
        return [
            'disk' => $this->faker->word(),
            'filename' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'meta' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'application_id' => Application::factory(),
        ];
    }
}
