<?php

use App\Http\Controllers\API\Media\EmbedVideoController;
use App\Http\Controllers\API\Media\MediaController;
use App\Http\Controllers\API\Media\UploadImageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('embed-video', EmbedVideoController::class)->name('embed-video');

    Route::post('upload-image', UploadImageController::class)->name('upload-image');

    Route::apiResource('/uploaded', MediaController::class)
        ->only('index', 'destroy')
        ->parameter('uploaded', 'media_id');
});
