<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SubcategoryController;

Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'admin']);


Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except('update');
    Route::apiResource('categories.subcategories', SubcategoryController::class)->scoped()->except('update');
    Route::apiResource('coupons', CouponController::class)->only('index', 'store');
});
