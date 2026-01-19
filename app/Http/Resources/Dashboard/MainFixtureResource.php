<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\CompetitionWeekResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainFixtureResource extends JsonResource
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
//            'season' => [
//                'id' => (integer)$this->season_id,
//                'name' => (string)$this->season?->name,
//            ],
            'home_club' => [
                'id' => (integer)$this->home_club_id,
                'name' => (string)$this->homeClub?->name,
                'image' => (string)$this->homeClub?->fileUrl,
            ],
            'away_club' => [
                'id' => (integer)$this->away_club_id,
                'name' => (string)$this->awayClub?->name,
                'image' => (string)$this->awayClub?->fileUrl,
            ],
            'home_club_result' => (integer)$this->home_club_result,
            'away_club_result' => (integer)$this->away_club_result,
            'match_date' => ($this->match_date ? Carbon::parse($this->match_date)->setTimezone('Asia/Riyadh')->format('Y-m-d') : null),
            'match_time' => ($this->match_time ? Carbon::parse($this->match_date . '' . $this->match_time)->setTimezone('Asia/Riyadh')->format('g:i A') : '--'),
            'match_period' => $this->when($this->match_period, (string)$this->match_period),
            'match_stadium' => $this->when($this->match_stadium, (string)$this->match_stadium),
            'status' => (string)$this->status?->value,
            'week' => $this->CompetitionWeek ? [
                'id' => $this->CompetitionWeek?->id,
                'name' => $this->CompetitionWeek?->name,
            ] : null,


        ];
    }
}
