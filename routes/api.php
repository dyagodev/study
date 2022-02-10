<?php

use App\Http\Controllers\{OrderController, UserController};
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/store', [UserController::class, 'store']);
});

Route::prefix('orders')->group(function () {
    Route::post('/store', [OrderController::class, 'store']);
});
