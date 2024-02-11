<?php

use App\Http\Controllers\Home\CategoriesController;
use App\Http\Controllers\Home\CoursesController;
use App\Http\Controllers\Home\SubcategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', CategoriesController::class);
Route::get('/categories/{category:slug}/subcategories', SubcategoriesController::class);
Route::get('courses', CoursesController::class);

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/instructor.php';
