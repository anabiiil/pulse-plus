<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueRankingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (integer)$this->user?->id,
            'points' => $this->points,
            'current_rank' => $this->current_rank,
            'name' => $this->user?->first_name ? $this->user?->full_name : $this->user?->team?->name,
            'image' => $this->user?->fileUrl,

        ];
    }
}
