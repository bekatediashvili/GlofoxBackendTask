<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{


    public function createCourse($courseData ,$studioId)
    {
        $course = new Course();
        $course->course_name = $courseData['course_name'];
        $course->start_date = $courseData['start_date'];
        $course->end_date = $courseData['end_date'];
        $course->capacity = $courseData['capacity'];
        $course->studio_id = $studioId;
        $course->save();
        return $course;
    }

}
