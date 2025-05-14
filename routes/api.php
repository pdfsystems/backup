<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\BackupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('backups', BackupController::class);
});
