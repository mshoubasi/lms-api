<?php
namespace App\Services;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubcategoryService
{
    public function createSubcategory(array $data, Model $category)
    {
        $data['slug'] = Str::slug($data['name']);

        $subcategory = $category->subcategories()->create($data);

        return $subcategory;
    }
}
