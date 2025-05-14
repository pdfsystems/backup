<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadBackupsRequest;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
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

        if ($builder->doesntExist()) {
            return response()->json(['error' => 'No matching backups found'], 404);
        }

        $archive = new ZipArchive;
        $tempPath = tempnam(sys_get_temp_dir(), 'backup_');
        if ($archive->open($tempPath, ZipArchive::CREATE) !== true) {
            return response()->json(['error' => 'Could not create zip archive'], 500);
        }
        try {
            $builder->each(fn (Backup $backup) => $this->addBackupToArchive($archive, $backup, $request->get('filename_meta_key')));
        } catch (RuntimeException $e) {
            $archive->close();
            unlink($tempPath);

            return response()->json([
                'error' => 'Could not add file to archive',
                'exception' => $e->getMessage(),
                'exception_class' => get_class($e),
            ], 500);
        }
        $archive->close();

        return response()->download($tempPath, 'Backups.zip')->deleteFileAfterSend();
    }

    private function addBackupToArchive(ZipArchive $archive, Backup $backup, ?string $filenameMetaKey = null): void
    {
        if (! empty($filenameMetaKey) && ! empty($backup->meta[$filenameMetaKey])) {
            $filename = "{$backup->meta[$filenameMetaKey]}.{$backup->getExtension()}";
        } else {
            $filename = $backup->filename;
        }

        if ($archive->addFromString($filename, Storage::get($backup->storagePath())) !== true) {
            throw new RuntimeException("Could not add file $filename to archive");
        }
    }
}
