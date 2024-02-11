<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseService
{
    public function storeCourse(array $data)
    {
        $data['slug'] = Str::slug($data['title']);

        try {
            if (isset($data['image'])) {
                $image = $data['image'];
                $filename = time().'.'.$image->getClientOriginalExtension();
                $subdirectoryPath = public_path("images/courses/{$data['slug']}");
                if (! file_exists($subdirectoryPath)) {
                    mkdir($subdirectoryPath, 0755, true);
                }
                $image->move($subdirectoryPath, $filename);
                $data['image'] = $filename;
            }

            if (isset($data['video'])) {
                $video = $data['video'];
                $filename = time().'.'.$video->getClientOriginalExtension();
                $subdirectoryPath = public_path("videos/courses/{$data['slug']}");
                if (! file_exists($subdirectoryPath)) {
                    mkdir($subdirectoryPath, 0755, true);
                }
                $video->move($subdirectoryPath, $filename);
                $data['video'] = $filename;
            }
            $data['instructor_id'] = request()->user()->id;
            $course = Course::create($data);
        } catch (Exception $e) {
            Log::error('Error uploading course image or video: '.$e->getMessage());
            throw $e;
        }

        return $course;
    }

    public function updateCourse(array $data, Course $course)
    {
        $data['slug'] = Str::slug($data['title']);

        if (isset($data['image'])) {
            $image = $data['image'];
            if ($course->image) {
                unlink(public_path("images/courses/{$course->slug}/{$course->image}"));
            }
            $filename = time().'.'.$image->getClientOriginalExtension();
            $subdirectoryPath = public_path("images/courses/{$data['slug']}");
            if (! file_exists($subdirectoryPath)) {
                mkdir($subdirectoryPath, 0755, true);
            }
            $image->move($subdirectoryPath, $filename);
            $data['image'] = $filename;
        }

        if (isset($data['video'])) {
            $video = $data['video'];
            if ($course->video) {
                unlink(public_path("videos/courses/{$course->slug}/{$course->video}"));
            }
            $filename = time().'.'.$video->getClientOriginalExtension();
            $subdirectoryPath = public_path("videos/courses/{$data['slug']}");
            if (! file_exists($subdirectoryPath)) {
                mkdir($subdirectoryPath, 0755, true);
            }
            $video->move($subdirectoryPath, $filename);
            $data['video'] = $filename;
        }

        $course->update($data);

        return $course;
    }
}
