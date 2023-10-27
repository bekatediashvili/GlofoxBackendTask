<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\DeleteBookingRequest;
use App\Models\Booking;
use App\Models\Course;
use App\Services\BookingService;

class BookingController extends Controller
{

    public function __construct(private readonly BookingService $bookingService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookingRequest $request, Course $course)
    {
        $data = $request->validated();


        $user = auth()->user();
        $bookingDate = $data['booking_date'];

        $isOwnerOrMember = $course->studio->user_id == $user->id || $course->studio->members->contains('id', $user->id);

        if (!$isOwnerOrMember) {
            return response()->json(['message' => "You do not have permission to book this course."], 403);
        }

        if ($bookingDate < $course->start_date || $bookingDate > $course->end_date) {
            return response()->json(['message' => "Booking on $bookingDate is not available"], 422);
        }
        $existingBooking = Booking::where('booking_date', $bookingDate)
            ->where('class_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingBooking) {
            return response()->json(['message' => "You have already made a booking for this date."], 422);
        }

        $booking = $this->bookingService->createNewBooking($data['member_name'], $bookingDate, $course->id, $user->id);

        return response()->json([
            'message' => "Booking was successfully created for $course->course_name on {$bookingDate}.",
            'booking' => $booking,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBookingRequest $request, Course $course, Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }


}
