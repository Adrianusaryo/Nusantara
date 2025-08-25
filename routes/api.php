<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});

Route::post('midtrans/token', [PaymentController::class, 'getToken']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user', [UserController::class, 'store']);
    Route::post('/order', [OrderController::class, 'OrderStore']);
    Route::get('/menu', [ItemController::class, 'index']);
    Route::get('/orders/{id?}', [OrderController::class, 'OrderShow']);
    // Route::get('/orders', [OrderController::class, 'OrderShow']);
    // Route::get('/menu', [ItemController::class, 'store']);

    // Route::patch('/menu/{id}', [ItemController::class, 'update']);
    // Route::delete('/menu/{id}', [ItemController::class, 'delete']);
    // Route::get('/order/{id}/set-as-done', [OrderController::class, 'SetAsDone']);
    // Route::get('/order/{id}/payment', [OrderController::class, 'Payment']);
    // Route::get('/order', [OrderController::class, 'index']);
    // Route::get('/order/{id}', [OrderController::class, 'show']);
    // Route::post('/order', [OrderController::class, 'store']);

    Route::get('/order-report', [OrderController::class, 'orderReport']);
});
