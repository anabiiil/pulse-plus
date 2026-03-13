<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->query('lang', app()->getLocale());

        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', $lang, useFallbackLocale: true),
        ];
    }
}
