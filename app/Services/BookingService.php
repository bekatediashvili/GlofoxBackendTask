<?php

namespace App\Services;

use App\Models\Booking;

class BookingService
{



    public function createNewBooking($memberName, $bookingDate, $courseId, $userId)
    {
        $booking = new Booking();
        $booking->member_name = $memberName;
        $booking->booking_date = $bookingDate;
        $booking->class_id = $courseId;
        $booking->user_id =$userId;
        $booking->save();
        return $booking;
    }
}
