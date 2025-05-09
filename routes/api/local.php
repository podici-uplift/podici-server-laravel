<?php

use App\Http\Controllers\API\Local\LocalAuthController;

Route::post('/socialite/email', [LocalAuthController::class, 'authFromEmail'])->name('auth.socialite.fromEmail');
