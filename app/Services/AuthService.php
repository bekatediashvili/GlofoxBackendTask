<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(LoginRequest $request): Authenticatable
    {
        $request->authenticate();
        $request->session()->regenerate();
        return auth()->user();
    }

    public function logout(Request $request): void
    {
        Auth::guard(get_auth_guard())->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function register(RegisterRequest $request): Authenticatable
    {
        $user = User::create($request->validated());
        Auth::login($user);
        return $user;
    }

}
