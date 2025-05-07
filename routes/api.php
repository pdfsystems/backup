<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\BackupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('backups', BackupController::class);
});
