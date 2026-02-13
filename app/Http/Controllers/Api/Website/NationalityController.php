<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\CountryResource;
use App\Models\Country;
use App\Support\Traits\Api\ApiResponseTrait;

class NationalityController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all active nationalities (countries)
     */
    public function index()
    {
        $countries = Country::where('status', 1)
            ->orderBy('name')
            ->get();

        return $this->responseData([
            'nationalities' => CountryResource::collection($countries)
        ]);
    }
}

