<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
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
            'type'=>$this->type?->value,
            'week' => $this->startWeek ? new CompetitionWeekResource($this->startWeek) : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),

        ];
    }
}
