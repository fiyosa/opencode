<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'timestamp' => now()->toISOString(),
]));

require app_path('Presentation/Core/Routes/auth.php');
require app_path('Presentation/Core/Routes/user.php');
