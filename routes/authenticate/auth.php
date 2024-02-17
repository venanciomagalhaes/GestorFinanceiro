<?php

use App\Http\Controllers\Authenticate\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->delete('/logout', [AuthController::class, 'logout'])->name('logout');
