<?php

namespace App\Http\Controllers\Api\Vendor\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Auth\LoginRequest;
use App\Http\Resources\VendorResource;
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
     * Handle vendor login request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->authenticateService->authenticate(
            guard: 'vendor',
            method: 'basic',
            credentials: $data
        );

        return ApiResponse::success([
            'vendor' => $result['user']?->toResource(VendorResource::class),
            'token' => $result['token'],
        ],
            message: 'Login successfully',
            status: 200
        );
    }
}

