<?php

use App\Http\Controllers\API\Auth\AuthLogoutController;
use App\Http\Controllers\API\Auth\AuthUserPasswordController;
use App\Http\Controllers\API\Auth\AuthUserProfileController;
use App\Http\Controllers\API\Auth\AuthUserUsernameController;
use App\Http\Controllers\API\AuthUserController;
use App\Http\Controllers\API\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('socialite')->name('socialite.')->controller(SocialiteController::class)->group(function () {
    Route::post('callback/{provider}', 'handleProviderCallback')->name('callback');

    Route::post('token/{provider}', 'authFromToken')->name('token');
});

Route::prefix('user')->name('user.')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profile')->name('profile.')->controller(AuthUserProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    Route::post('password', AuthUserPasswordController::class)->name('password-update');
    Route::post('username', AuthUserUsernameController::class)->name('username-update');

    Route::post('logout', AuthLogoutController::class)->name('logout');
});
