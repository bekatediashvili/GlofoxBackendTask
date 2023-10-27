<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookAsGuestController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {

        $guest = User::create([
            'name' => 'Guest',
            'email' => null,
            'password' => null,
        ]);
       Auth::loginUsingId($guest->id);
        if ($guest) {
            return response()->json(['message' => 'Guest logged in successfully', 'user' => $guest]);
        } else {

            return response()->json(['message' => 'Guest login failed'], 401);
        }
    }
}
