<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
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
            'id' => (integer)$this->id,
            'name' => (array)$this->getTranslations('name'),
            'region' => (array)$this->getTranslations('region'),
            'subregion' => (array)$this->getTranslations('subregion'),
            'iso3' => $this->iso3,
            'phone_code' => $this->phone_code,
            'status' => $this->status?->value,
            'created_at' => (string)($this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d') : null),
        ];
    }
}
