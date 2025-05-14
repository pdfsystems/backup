<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListBackupsRequest;
use App\Http\Requests\StoreBackupRequest;
use App\Http\Requests\UpdateBackupRequest;
use App\Models\Backup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BackupController extends Controller
{
    use AuthorizesRequests;

    public function index(ListBackupsRequest $request): Response
    {
        $builder = Backup::orderByDesc('created_at')->with('application');

        if ($request->filled('application_id')) {
            $builder->whereApplicationId($request->get('application_id'));
        }

        if ($request->filled('type')) {
            $builder->whereType($request->get('type'));
        }

        return response()->json($builder->paginate());
    }

    public function store(StoreBackupRequest $request): Response
    {
        $backup = Backup::create($request->validated());
        $extension = pathinfo($backup->filename, PATHINFO_EXTENSION);
        $request->file('file')->storeAs("backups/{$backup->getKey()}.$extension");

        return response()->json($backup, Response::HTTP_CREATED);
    }

    public function show(Backup $backup): Response
    {
        $this->authorize('view', $backup);

        return response()->json($backup->load('application'));
    }

    public function download(Backup $backup)
    {
        $this->authorize('download', $backup);
        $extension = pathinfo($backup->filename, PATHINFO_EXTENSION);

        return redirect(
            Storage::temporaryUrl("backups/{$backup->getKey()}.$extension", now()->addHour())
        );
    }

    public function update(UpdateBackupRequest $request, Backup $backup): Response
    {
        return response()->json(tap($backup)->update($request->validated()));
    }

    public function destroy(Backup $backup): Response
    {
        $this->authorize('delete', $backup);

        $backup->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
