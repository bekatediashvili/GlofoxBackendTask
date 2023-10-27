<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Studio;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{

    public function __construct(private readonly CourseService $courseService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index($studioId)
    {
        $user = auth()->user();

        $courses = Course::where('studio_id', $user->id)
            ->where('studio_id', $studioId)
            ->get();

        if ($courses->isNotEmpty()) {
            return response()->json(['courses' => $courses]);
        } else {
            return response()->json(['message' => 'You do not own any courses.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request, Studio $studio)
    {
        $data = $request->validated();
        $existingClass = $studio->courses()
            ->where('course_name', $data['course_name'])
            ->first();


        $overlappingClass = $studio->courses()
            ->where(function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where('start_date', '<=', $data['end_date'])
                        ->where('end_date', '>=', $data['start_date']);
                });
            })
            ->first();

        if ($existingClass) {
            return response()->json(['message' => 'A class with the same name already exists in the studio.'], 422);
        }

        if ($overlappingClass) {
            return response()->json(['message' => 'A class with chosen dates already exists in the studio.'], 422);
        }
        $course = $this->courseService->createCourse($data, $studio->id);

        return response()->json(['message' => 'Course created successfully', 'data' => new  CourseResource($course)], 201);
    }

    public function calculateClassesAndCapacity($courseName): JsonResponse
    {
        $course = Course::where('course_name', $courseName)->first();

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $startDate = $course->start_date;
        $endDate = $course->end_date;
        $numberOfClasses = $startDate->diffInDays($endDate) + 1;

        $totalCapacity = $numberOfClasses * $course->capacity;

        return response()->json([
            'course_name' => $courseName,
            'number_of_classes' => $numberOfClasses,
            'total_capacity' => $totalCapacity,
            'capacity_for_each_class' => $course->capacity
        ]);
    }
}
