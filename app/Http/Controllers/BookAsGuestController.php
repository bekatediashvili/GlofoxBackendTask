<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BookAsGuestController extends Controller
{

    public function __construct(private readonly UserService $userService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $guest = $this->userService->createGuest();
        Auth::loginUsingId($guest->id);
        return response()->json(UserResource::make($guest));

    }
}
