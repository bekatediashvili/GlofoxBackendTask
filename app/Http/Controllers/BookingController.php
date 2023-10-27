<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteBookingRequest;
use App\Http\Requests\CreateBookingRequest;
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


    public function store(CreateBookingRequest $request, Course $course)
    {
        $data = $request->validated();

        $user = auth()->user();
        $bookingDate = $data['booking_date'];

        if ($bookingDate < $course->start_date || $bookingDate > $course->end_date) {
            return response()->json(['message' => "Booking on $bookingDate is not available"], 422);
        }
            $booking = new Booking();
            $booking->member_name = $data['member_name'];
            $booking->booking_date = $bookingDate;
            $booking->class_id = $course->id;
            $booking->user_id = $user->id;

            $booking->save();

        return response()->json(['message' => "Booking was successfully created for $course->course_name on {$bookingDate}."]);
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
    public function destroy(DeleteBookingRequest $request, Course $course, Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
      return   response()->json(['message' => 'Booking deleted successfully']);
    }


}
