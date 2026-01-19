<?php

use App\Http\Controllers\Admin\Api\Auth\RegisterController;
use App\Http\Controllers\Admin\Api\Auth\SendOtpController;
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for admin users.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group with admin authentication.
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class);
});

// Protected routes (authentication required)
Route::middleware('auth:admin-api')->group(function () {

    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
});

