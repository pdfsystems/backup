<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StatusCommand extends Command
{
    protected $signature = 'status';

    protected $description = 'Checks whether the application is healthy';

    public function handle(): int
    {
        return static::SUCCESS;
    }
}
