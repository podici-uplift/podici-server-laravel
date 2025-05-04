<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(base_path('routes/api/auth.php'));

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
