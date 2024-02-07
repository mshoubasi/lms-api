<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResoruce;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with('subcategories')->latest()->get();

        return  CategoryResoruce::collection($category);
    }

    public function store(CategoryRequest $request, CategoryService $categoryService)
    {
        $category = $categoryService->createCategory($request->validated());

        return new CategoryResoruce($category);
    }

    public function show(Category $category)
    {
        return new CategoryResoruce($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json('Deleted');
    }
}
