<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseFilterRequest;
use App\Http\Resources\CourseResoruce;
use App\Models\Course;

class CoursesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CourseFilterRequest $request)
    {
        $courses = Course::When($request->category, function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })
            ->when($request->subcategory, function ($query) use ($request) {
                $query->where('subcategory_id', $request->subcategory);
            })
            ->when($request->title, function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->title.'%');
            })
            ->when($request->description, function ($query) use ($request) {
                $query->where('description', 'like', '%'.$request->description.'%');
            })
            ->latest()->paginate();

        return CourseResoruce::collection($courses);
    }
}
