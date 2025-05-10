<?php

use App\Http\Controllers\API\AuthUserController;
use App\Http\Controllers\API\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('socialite')->name('socialite.')->controller(SocialiteController::class)->group(function () {
    Route::post('callback/{provider}', 'handleProviderCallback')->name('callback');

    Route::post('token/{provider}', 'authFromToken')->name('token');
});

Route::prefix('user')->name('user.')->middleware(['auth:sanctum'])->controller(AuthUserController::class)->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'getProfile')->name('get');
        Route::put('/', 'updateProfile')->name('update');

        // DOB update needs KYC
        Route::post('update-password', 'updatePassword')->name('password.update');
        Route::post('update-username', 'updateUsername')->name('username.update');
    });

    Route::post('logout', 'logout')->name('logout');
});
