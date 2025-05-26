<?php

use App\Http\Controllers\API\Local\LocalAuthController;
use App\Http\Controllers\API\Local\SnippetController;

Route::post('/socialite/email', [LocalAuthController::class, 'authFromEmail'])->name('auth.socialite.fromEmail');

Route::get('/snippet', SnippetController::class)->name('snippet');
