<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Studio;
use Illuminate\Http\Request;

class CourseController extends Controller
{
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $date = $request->validated();

        $studio = Studio::where('user_id', auth()->user()->id)->first();

        if ($studio) {
            $course = new Course();
            $course->course_name = $date['course_name'];
            $course->start_date = $date['start_date'];
            $course->end_date = $date['end_date'];
            $course->capacity = $date['capacity'];
            $course->studio_id = $studio->id;
            $course->save();

            return response()->json(['message' => 'Course created successfully', 'data' =>  new  CourseResource($course)], 201);

        } else {
            return response()->json(['message' => 'You do not own a studio, unable to create a course.'], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
