<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->key,
            'name' => __("lang.statistics.$this->key"),
            'home_club_result' => (float)$this->home_club_result,
            'away_club_result' => (float)$this->away_club_result,
        ];
    }
}
