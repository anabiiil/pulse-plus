<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\Contracts\RegistrationServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegistrationServiceInterface $registrationService
    )
    {
    }

    /**
     * Handle user registration request.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->registrationService->register(
            guard: 'user',
            method: $data['auth_type'],
            credentials: $data
        );

        return ApiResponse::success(
            data: [
                'user' => $result['user']?->toResource(UserResource::class),
                'token' => $result['token'],
            ],
            message: 'User registered successfully',
            status: 201
        );
    }
}
