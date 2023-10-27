<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Studio;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct(private readonly CourseService $courseService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studios = Studio::where('user_id', auth()->user()->id)->get();

        if ($studios->isNotEmpty()) {
            $courses = Course::all();
            return response()->json(['courses' => $courses]);
        } else {
            return response()->json(['message' => 'You do not own any studios.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $date = $request->validated();
        $studioId = request()->attributes->get('studio_id');
        $dataWithStudioId = array_merge($date, ['studio_id' => $studioId->id]);

        $course = $this->courseService($dataWithStudioId);

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
