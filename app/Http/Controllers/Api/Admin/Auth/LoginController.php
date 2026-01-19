<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\AdminResource;
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
     * Handle admin login request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->authenticateService->authenticate(
            guard: 'admin',
            method: 'basic',
            credentials: $data
        );

        return ApiResponse::success([
            'user' => $result['user']?->toResource(AdminResource::class),
            'token' => $result['token'],
        ],
            message: 'Login successfully',
            status: 200
        );
    }
}
