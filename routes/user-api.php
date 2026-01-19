<?php

use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\Auth\SendOtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for regular users.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group with user authentication.
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('send-otp', SendOtpController::class);
});

// Protected routes (authentication required)
Route::middleware('auth:user-api')->group(function () {
    Route::get('/profile', static function (Request $request) {
        return $request->user();
    });
});
