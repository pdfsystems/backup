<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadBackupsRequest;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupMultiDownloadController extends Controller
{
    public function __invoke(DownloadBackupsRequest $request)
    {
        $builder = Backup::orderByDesc('created_at');
        $builder->whereApplicationId($request->get('application_id'));
        $builder->whereType($request->get('type'));
        foreach ($request->getMetaFilters() as $key => $value) {
            $builder->where("meta->$key", '=', $value);
        }

        $archive = new ZipArchive;
        $tempPath = tempnam(sys_get_temp_dir(), 'backup_');
        $archive->open($tempPath, ZipArchive::CREATE);
        $builder->each(fn (Backup $backup) => $this->addBackupToArchive($archive, $backup, $request->get('filename_meta_key')));
        $archive->close();

        return response()->download($tempPath, 'Backups.zip')->deleteFileAfterSend();
    }

    private function addBackupToArchive(ZipArchive $archive, Backup $backup, ?string $filenameMetaKey = null): void
    {
        if (!empty($filenameMetaKey) && ! empty($backup->meta[$filenameMetaKey])) {
            $filename = "{$backup->meta[$filenameMetaKey]}.{$backup->getExtension()}";
        } else {
            $filename = $backup->filename;
        }

        $archive->addFromString($filename, Storage::get($backup->storagePath()));
    }
}
