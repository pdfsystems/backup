<?php

namespace App\Observers;

use App\Models\Backup;

class BackupObserver
{
    public function creating(Backup $backup): void
    {
        if (empty($backup->disk)) {
            $backup->disk = config('filesystems.default');
        }
    }
}
