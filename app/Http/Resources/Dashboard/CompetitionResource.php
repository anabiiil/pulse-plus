<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>(integer)$this->id,
            'name'=>(array)$this->getTranslations('name'),
            'description'=>(array)$this->getTranslations('description'),
            'season' => $this->season_id ? $this->whenLoaded('season', fn() => new SeasonResource($this->season)) : null,
            'season_id' => $this->season_id,
            'status' => (boolean) $this->status?->value,
            'created_at' => (string) $this->created_at,

//            'weeks'=>$this->whenLoaded('weeks', fn () =>  CompetitionWeekResource::collection($this->weeks)),
        ];
    }
}
