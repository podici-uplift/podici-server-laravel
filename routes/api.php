<?php

use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(base_path('routes/api/auth.php'));

    Route::prefix('lookup')->name('lookup.')->group(base_path('routes/api/lookup.php'));

    if (config('app.env') == 'local') {
        Route::prefix('local')->name('local.')->group(base_path('routes/api/local.php'));
    }
});
