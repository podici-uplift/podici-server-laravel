<?php

use App\Http\Controllers\API\User\ProfileController;
use App\Http\Controllers\API\User\Shop\CreateShopController;
use App\Http\Controllers\API\User\Shop\Product\ProductController;
use App\Http\Controllers\API\User\Shop\Product\ProductMediaController;
use App\Http\Controllers\API\User\Shop\UpdateShopController;
use App\Http\Controllers\API\User\UpdatePasswordController;
use App\Http\Controllers\API\User\UpdateUsernameController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    Route::post('password', UpdatePasswordController::class)->name('password-update');
    Route::post('username', UpdateUsernameController::class)->name('username-update');

    Route::prefix('shop')->name('shop.')->group(function () {
        Route::post('create', CreateShopController::class)->name('create');
        Route::post('update', UpdateShopController::class)->name('update');
    });

    Route::apiResource('products', ProductController::class)
        ->parameter('product', 'product_id');

    Route::apiResource('products.media', ProductMediaController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameter('media', 'media');
});
