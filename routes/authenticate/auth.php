<?php

use App\Http\Controllers\Authenticate\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::put('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::put('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::put('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verifyEmail');
Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});


