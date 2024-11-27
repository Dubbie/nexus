<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\InsurerController;
use App\Http\Controllers\Api\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/insurers', [InsurerController::class, 'index'])->name('api.insurers.index');

Route::middleware('auth:api')->group(function () {
    // Only devs
    Route::middleware('role:developer')->group(function () {
        Route::post('/insurers', [InsurerController::class, 'store'])->name('api.insurers.store');
        Route::put('/insurers/{insurer}', [InsurerController::class, 'update'])->name('api.insurers.update');
        Route::delete('/insurers/{insurer}', [InsurerController::class, 'destroy'])->name('api.insurers.destroy');
    });

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('api.activity-log.index');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('api.statistics.index');
});
