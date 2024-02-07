<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResoruce;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category)
    {
        $subcategories = $category->subcategories()->latest()->get();

        return SubcategoryResoruce::collection($subcategories);
    }
}
