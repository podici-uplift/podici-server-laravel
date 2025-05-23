<?php

use App\Http\Controllers\API\Shop\CreateShopController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('create', CreateShopController::class)->name('create');
});
