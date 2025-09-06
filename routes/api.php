<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::post('midtrans/token', [PaymentController::class, 'getToken']);

Route::prefix('nusantara')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/order', [OrderController::class, 'OrderStore']);
    Route::get('/menu', [ItemController::class, 'index']);
    Route::get('/orders/{id?}', [OrderController::class, 'OrderShow']);
});
