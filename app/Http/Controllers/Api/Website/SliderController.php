<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\SliderResource;
use App\Models\Slider;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;

class SliderController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of active sliders.
     */
    public function index()
    {
        $sliders = Slider::where('status', StatusEnum::ACTIVE)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->responseData(SliderResource::collection($sliders));
    }

    /**
     * Display the specified slider.
     */
    public function show($id)
    {
        $slider = Slider::where('status', StatusEnum::ACTIVE)
            ->findOrFail($id);

        return $this->responseData(new SliderResource($slider));
    }
}
