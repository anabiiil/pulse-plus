<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Support\Enums\User\MaritalStatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;

class EnumController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get marital status options
     */
    public function maritalStatus()
    {
        return $this->responseData([
            'marital_status_options' => MaritalStatusEnum::options()
        ]);
    }
}

