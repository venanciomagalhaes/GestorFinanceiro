<?php

use App\Http\Controllers\Authenticate\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
