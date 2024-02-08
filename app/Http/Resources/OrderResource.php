<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = $this->course;
        $user = $this->user;

        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'date' => $this->date,
            'course' => [
                'title' => $course->title,
                'price' => $course->selling_price,
            ],
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];
    }
}

