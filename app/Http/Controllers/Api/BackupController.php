<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBackupRequest;
use App\Http\Requests\UpdateBackupRequest;
use App\Models\Backup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class BackupController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $this->authorize('view-any', Backup::class);

        return response()->json(Backup::orderBy('name')->get());
    }

    public function store(StoreBackupRequest $request): Response
    {
        return response()->json(Backup::create($request->validated()), Response::HTTP_CREATED);
    }

    public function show(Backup $backup): Response
    {
        $this->authorize('view', $backup);

        return response()->json($backup);
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
