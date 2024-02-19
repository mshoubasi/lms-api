<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResoruce;
use App\Models\Course;
use App\Services\CourseService;

class CourseController extends Controller
{
    public function index()
    {
        $course = Course::with(['instructor', 'category', 'subcategory'])->latest()->get();

        return CourseResoruce::collection($course);
    }

    public function store(CourseStoreRequest $request, CourseService $courseService)
    {
        $course = $courseService->storeCourse($request->validated());

        return $this->respondWithSucsses(new CourseResoruce($course));
    }

    public function update(CourseUpdateRequest $request, CourseService $courseService, Course $course)
    {
        $course = $courseService->updateCourse($request->validated(), $course);

        return $this->respondWithSucsses(new CourseResoruce($course));
    }

    public function show(Course $course)
    {
        return new CourseResoruce($course);
    }

    public function destroy(Course $course)
    {
        unlink(public_path("images/courses/{$course->slug}/{$course->image}"));
        unlink(public_path("videos/courses/{$course->slug}/{$course->video}"));

        $course->delete();

        return $this->destroyed();
    }
}
