<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $this->authorize('view-any', Application::class);

        return response()->json(Application::orderBy('name')->get());
    }

    public function store(StoreApplicationRequest $request): Response
    {
        return response()->json(Application::create($request->validated()), Response::HTTP_CREATED);
    }

    public function show(Application $application): Response
    {
        $this->authorize('view', $application);

        return response()->json($application);
    }

    public function update(UpdateApplicationRequest $request, Application $application): Response
    {
        return response()->json(tap($application)->update($request->validated()));
    }

    public function destroy(Application $application): Response
    {
        $this->authorize('delete', $application);

        $application->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
