<?php

use App\Http\Controllers\Instructor\AuthController;
use App\Http\Controllers\Instructor\CourseController;
use Illuminate\Support\Facades\Route;

Route::post('instructor/register', [AuthController::class, 'register']);
Route::post('instructor/login', [AuthController::class, 'login']);
Route::post('instructor/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'instructor']);

Route::middleware(['auth:sanctum', 'instructor'])->prefix('instructor')->group(function () {
    Route::apiResource('courses', CourseController::class);
});
