<?php

use App\Presentation\Core\Controllers\UserController;
use App\Presentation\Core\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('users.')->middleware('auth:api')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

    Route::prefix('{user}/detail')->name('detail.')->group(function () {
        Route::get('/', [UserDetailController::class, 'show'])->name('show');
        Route::post('/', [UserDetailController::class, 'store'])->name('store');
        Route::put('/', [UserDetailController::class, 'update'])->name('update');
    });
});
