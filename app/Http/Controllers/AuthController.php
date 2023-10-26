<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $this->authService->login($request);

        return response()->json();
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);

        return response()->json();
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request);

        return response()->json([UserResource::make($user)]);
    }

}
