<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslations('name'),
            'name_ar' => $this->getTranslation('name', 'ar'),
            'name_en' => $this->getTranslation('name', 'en'),
            'iso3' => $this->iso3,
            'phone_code' => $this->phone_code,
        ];
    }
}

