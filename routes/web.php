<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InsurerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Passport\ClientController as PassportClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::middleware('auth')->group(function () {
    // Developer routes
    Route::middleware('role:developer')->group(function () {
        // Clients
        Route::prefix('client')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        });

        // Insurers
        Route::prefix('insurer')->group(function () {
            Route::get('/', [InsurerController::class, 'index'])->name('insurers.index');
        });

        // Users
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
        });

        // Roles
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        });

        // Passport
        Route::get('/oauth/clients', [PassportClientController::class, 'forUser'])->name('passport.clients.index');
        Route::post('/oauth/clients', [PassportClientController::class, 'store'])->name('passport.clients.store');
        Route::put('/oauth/clients/{client}', [PassportClientController::class, 'update'])->name('passport.clients.update');
        Route::delete('/oauth/clients/{client}', [PassportClientController::class, 'destroy'])->name('passport.clients.destroy');
    });

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
