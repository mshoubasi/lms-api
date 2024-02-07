<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResoruce;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $categories = Category::latest()->get();

        return CategoryResoruce::collection($categories);
    }
}
