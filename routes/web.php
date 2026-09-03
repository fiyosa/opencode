<?php

use App\Presentation\Core\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

Route::get('/api-docs', [SpaController::class, 'docs']);

Route::get('/{any?}', [SpaController::class, 'index'])->where('any', '.*');
