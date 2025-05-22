<?php

use App\Http\Controllers\API\Lookup\ShopNameAvailabilityController;
use Illuminate\Support\Facades\Route;

Route::prefix('availability')->name('availability.')->group(function () {
    Route::post('shop-name', ShopNameAvailabilityController::class)->name('shop-name');
});
