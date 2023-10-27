<?php

namespace App\Http\Controllers;

use App\Models\Studio;

class BecomeMemberController extends Controller
{
    public function __invoke(Studio $studio)
    {
        $user = auth()->user();

        $studio->members()->attach($user->id);

        return response()->json(['message' => 'You are now a member of the studio.']);
    }
}
