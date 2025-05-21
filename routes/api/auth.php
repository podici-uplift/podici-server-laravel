<?php

use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\ProfileController;
use App\Http\Controllers\API\Auth\SocialiteController;
use App\Http\Controllers\API\Auth\UpdatePasswordController;
use App\Http\Controllers\API\Auth\UpdateUsernameController;
use App\Http\Controllers\API\CreateShopController;
use Illuminate\Support\Facades\Route;

Route::prefix('socialite')->name('socialite.')->controller(SocialiteController::class)->group(function () {
    Route::post('callback/{provider}', 'handleProviderCallback')->name('callback');

    Route::post('token/{provider}', 'authFromToken')->name('token');
});

Route::prefix('user')->name('user.')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    Route::post('password', UpdatePasswordController::class)->name('password-update');
    Route::post('username', UpdateUsernameController::class)->name('username-update');

    Route::post('logout', LogoutController::class)->name('logout');
});

Route::prefix('shop')->name('shop.')->middleware(['auth:sanctum'])->group(function () {
    Route::post('create', CreateShopController::class)->name('create');
});
