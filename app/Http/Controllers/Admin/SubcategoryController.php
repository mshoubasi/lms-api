<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SubcategoryRequest;
use App\Http\Resources\SubcategoryResoruce;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\SubcategoryService;

class SubcategoryController extends Controller
{
    public function index(Category $category)
    {
        return SubcategoryResoruce::collection($category->subcategories()->latest()->get());
    }

    public function store(SubcategoryRequest $request, SubcategoryService $subcategoryService, Category $category)
    {
        $subcategory = $subcategoryService->createSubcategory($request->validated(), $category);

        return new SubcategoryResoruce($subcategory);
    }

    public function show(Category $category, Subcategory $subcategory)
    {
        return new SubcategoryResoruce($subcategory);
    }

    public function destroy(Category $category, Subcategory $subcategory)
    {
        $subcategory->delete();

        return response()->json('Deleted');
    }

}
