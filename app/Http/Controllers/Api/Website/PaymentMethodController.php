<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display active payment methods (for checkout).
     */
    public function index(): JsonResponse
    {
        $methods = PaymentMethod::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return $this->responseData(PaymentMethodResource::collection($methods));
    }
}
