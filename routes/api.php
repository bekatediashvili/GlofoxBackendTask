<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BecomeMemberController;
use App\Http\Controllers\BookAsGuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('studio', StudioController::class)
    ->only('index', 'store')->middleware('auth:sanctum');

Route::apiResource('class', CourseController::class)
    ->only('index', 'store')->middleware('auth:sanctum');

Route::get('class/calculate/{courseName}', [CourseController::class, 'calculateClassesAndCapacity'])
    ->middleware('auth:sanctum');

Route::apiResource('class/{course}/booking', BookingController::class)
    ->only('index', 'store', 'destroy')->middleware('auth:sanctum');


Route::post('member/{studio}', BecomeMemberController::class)->middleware('auth:sanctum');


Route::post('/guest', BookAsGuestController::class)->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::middleware(['auth'])->group(static function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});
