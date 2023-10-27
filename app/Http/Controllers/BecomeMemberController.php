<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Studio;
use App\Models\User;

class BecomeMemberController extends Controller
{
    public function __invoke(Studio $studio)
    {
        $user = auth()->user();
        $existingMember = $studio->members()->where('user_id', $user->id)->exists();

        if ($existingMember) {
            return response()->json(['message' => 'You are already a member of the studio.']);
        }

        $studio->members()->attach($user->id);

        return response()->json(['message' => 'You are now a member of the studio.']);
    }
}
