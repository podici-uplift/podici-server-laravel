<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(base_path('routes/api/auth.php'));

if (config('app.env') == 'local') {
    Route::prefix('local')->name('local.')->group(base_path('routes/api/local.php'));
}
