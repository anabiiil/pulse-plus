<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendOtpController extends Controller
{
    /**
     * Handle send OTP request for user registration.
     */
    public function __invoke(Request $request): JsonResponse
    {

        return ApiResponse::success(
            message: 'Send OTP successfully',
            status: 200
        );
    }
}
