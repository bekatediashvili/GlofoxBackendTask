<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Course;
use App\Models\Studio;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::all();
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


    public function store(BookingRequest $request, Course $course)
    {
        $data = $request->validated();
        $user = auth()->user();

        $studio = $course->studio;
        $course = $studio->courses->where('studio_id', $studio->id)->first();
        if ($course) {

            $booking = new Booking();
            $booking->member_name = $data['member_name'];
            $booking->booking_date = $data['booking_date'];
            $booking->class_id = $course->id;
            $booking->user_id = $user->id;

            $booking->save();

            return response()->json(['message' => 'Booking created successfully', 'data' => new BookingResource($booking)], 201);
        } else {
            // User has not previously booked this class and is not authorized to book
            return response()->json(['message' => 'You are not authorized to book this class.'], 403);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id === auth()->user()->id) {

            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized to delete this booking'], 403);
        }
    }

}
