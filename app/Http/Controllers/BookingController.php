<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteBookingRequest;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Course;
use App\Models\Studio;
use App\Services\BookingService;
use Illuminate\Http\Request;

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

        if ($bookingDate < $course->start_date || $bookingDate > $course->end_date) {
            return response()->json(['message' => "Booking on $bookingDate is not available"], 422);
        }

        $booking = $this->bookingService->createNewBooking($data['member_name'], $bookingDate, $course->id, $user->id);

        return response()->json(['message' => "Booking was successfully created for $course->course_name on {$bookingDate}."]);
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
