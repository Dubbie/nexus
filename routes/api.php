<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\InsurerController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/insurers', [InsurerController::class, 'index'])->name('api.insurers.index');

Route::middleware('auth:api')->group(function () {
    // SSO related routes
    Route::prefix('user')->name('api.user.')->group(function () {
        Route::get('/self', [UserController::class, 'self'])->name('self');
        Route::get('/validate-token', [UserController::class, 'validateToken'])->name('validate-token');
    });

    // Developer routes
    Route::middleware('role:developer')->group(function () {
        // Insurer routes
        Route::prefix('insurer')->name('api.insurer.')->group(function () {
            Route::get('/', [InsurerController::class, 'index'])->name('index');
            Route::post('/', [InsurerController::class, 'store'])->name('store');
            Route::put('/{insurer}', [InsurerController::class, 'update'])->name('update');
            Route::delete('/{insurer}', [InsurerController::class, 'destroy'])->name('destroy');
        });

        // User management routes
        Route::prefix('user')->name('api.user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Role management routes
        Route::prefix('role')->name('api.role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{user}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{user}', [RoleController::class, 'destroy'])->name('destroy');
        });
    });

    // General routes
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('api.activity-log.index');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('api.statistics.index');
});
