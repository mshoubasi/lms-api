<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $instructor = $this->instructor;
        $category = $this->category;
        $subcategory = $this->subcategory;

        return [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'video' => $this->video,
            'duration' => $this->duration,
            'selling_price' => $this->selling_price,
            'discount_price' => $this->discount_price,
            'instructor_id' => $instructor->toArray(), // Eager load instructor
            'category_id' => $category->toArray(), // Eager load category
            'subcategory_id' => $subcategory->toArray(), // Eager load subcategory
        ];
    }
}
