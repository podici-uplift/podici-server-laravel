<?php

use App\Http\Controllers\API\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/auth')->name('api.auth.')->group(function () {
    Route::prefix('socialite')->name('socialite.')->controller(SocialiteController::class)->group(function () {
        Route::post('callback/{provider}', 'handleProviderCallback')->name('callback');

        Route::post('token/{provider}', 'authFromToken')->name('token');
    });
});
