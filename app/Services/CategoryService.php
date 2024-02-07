<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function createCategory(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        return $category;
    }
}
