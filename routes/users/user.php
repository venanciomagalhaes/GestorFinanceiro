<?php

use App\Http\Controllers\User\UserController;

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::put('/users', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');
});
