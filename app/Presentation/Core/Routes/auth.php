<?php

use App\Presentation\Core\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:api')
        ->name('logout');
    Route::get('/user', [AuthController::class, 'user'])
        ->middleware('auth:api')
        ->name('user');
});
