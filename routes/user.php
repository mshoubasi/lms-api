<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\ApplyCouponsController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);
Route::post('user/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'user']);


Route::middleware(['auth:sanctum', 'user'])->group(function () {
    Route::apiResource('orders', OrderController::class)->only('index', 'show');
    Route::post('courses/{course}/order', [OrderController::class, 'store']);
});
