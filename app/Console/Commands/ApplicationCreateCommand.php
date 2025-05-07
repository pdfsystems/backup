<?php

namespace App\Console\Commands;

use App\Models\Application;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

class ApplicationCreateCommand extends Command
{
    protected $signature = 'application:create';

    protected $description = 'Creates a new application';

    public function handle(): int
    {
        $name = text('Enter the name of the application', required: true);
        $url = text('Enter the URL of the application');

        $application = Application::create([
            'name' => $name,
            'url' => $url,
        ]);

        $this->info("Application $application->name successfully created with id {$application->getKey()}.");

        return static::SUCCESS;
    }
}
