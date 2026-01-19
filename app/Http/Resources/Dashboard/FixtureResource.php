<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\Dashboard\FixtureEventResource;

class FixtureResource extends JsonResource
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
            'home_club' => [
                'id' => (integer)$this->home_club_id,
                'name' => (array)$this->homeClub?->getTranslations('name'),
                'image' => (string)$this->homeClub?->fileUrl,
            ],
            'away_club' => [
                'id' => (integer)$this->away_club_id,
                'name' => (array)$this->awayClub?->getTranslations('name'),
                'image' => (string)$this->awayClub?->fileUrl,
            ],
            'home_club_result' => (integer)$this->home_club_result,
            'away_club_result' => (integer)$this->away_club_result,
            'match_date' => ($this->match_date ? Carbon::parse($this->match_date)->setTimezone('Asia/Riyadh')->format('Y-m-d') : null),
            'match_time' => ($this->match_time ? Carbon::parse($this->match_time)->setTimezone('Asia/Riyadh')->format('H:i:s') : null),
            'match_date_time' => ($this->match_date_time ? Carbon::parse($this->match_date_time)->setTimezone('Asia/Riyadh')->format('Y-m-d H:i:s') : null),
            'match_period' => (string)$this->match_period,
            'match_stadium' => (string)$this->homeClub?->stadium,
            'status' => (string)$this->status?->value,
            'statistics' => $this->whenLoaded('statistics', StatisticsResource::collection($this->statistics)),
            'week' => $this->CompetitionWeek ? new CompetitionWeekResource($this->CompetitionWeek) : null,
            'events' => $this->whenLoaded('events', FixtureEventResource::collection($this->events)),
        ];
    }
}
