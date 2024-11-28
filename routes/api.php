<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\InsurerController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user/self', [UserController::class, 'self'])->name('api.user.self')->middleware('auth:api');
Route::get('/insurers', [InsurerController::class, 'index'])->name('api.insurers.index');

Route::middleware('auth:api')->group(function () {
    // Only devs
    Route::middleware('role:developer')->group(function () {
        Route::post('/insurers', [InsurerController::class, 'store'])->name('api.insurers.store');
        Route::put('/insurers/{insurer}', [InsurerController::class, 'update'])->name('api.insurers.update');
        Route::delete('/insurers/{insurer}', [InsurerController::class, 'destroy'])->name('api.insurers.destroy');

        Route::prefix('insurer')->group(function () {
            Route::post('/', [InsurerController::class, 'store'])->name('api.insurers.store');
            Route::put('/{insurer}', [InsurerController::class, 'update'])->name('api.insurers.update');
            Route::delete('/{insurer}', [InsurerController::class, 'destroy'])->name('api.insurers.destroy');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('api.users.index');
            Route::post('/', [UserController::class, 'store'])->name('api.users.store');
            Route::put('/{user}', [UserController::class, 'update'])->name('api.users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('api.users.destroy');
        });

        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('api.roles.index');
            Route::post('/', [RoleController::class, 'store'])->name('api.roles.store');
            Route::put('/{user}', [RoleController::class, 'update'])->name('api.roles.update');
            Route::delete('/{user}', [RoleController::class, 'destroy'])->name('api.roles.destroy');
        });
    });

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('api.activity-log.index');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('api.statistics.index');
});
