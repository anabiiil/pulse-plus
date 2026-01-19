<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\Contracts\AuthenticateServiceInterface;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        protected AuthenticateServiceInterface $authenticateService
    )
    {
    }

    /**
     * Handle user login request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->authenticateService->authenticate(
            guard: 'user',
            method: $data['auth_type'],
            credentials: $data
        );

        return ApiResponse::success([
            'user' => $result['user']?->toResource(UserResource::class),
            'token' => $result['token'],
        ],
            message: 'Login successfully',
            status: 200
        );
    }
}
