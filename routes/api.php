<?php

use App\Http\Controllers\Api\InsurerController;
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
});
