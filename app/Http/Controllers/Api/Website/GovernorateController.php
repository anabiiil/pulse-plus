<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\GovernorateResource;
use App\Models\Governorate;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;

class GovernorateController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display active governorates with their delivery price (for checkout).
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $governorates = Governorate::query()
            ->where('status', StatusEnum::ACTIVE)
            ->orderBy('id')
            ->get();

        return $this->responseData(GovernorateResource::collection($governorates));
    }
}
