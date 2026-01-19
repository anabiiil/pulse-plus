<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\TeamManagement;
use App\Models\TeamPlayer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerMainResource extends JsonResource
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
            'name' => (array)$this->getTranslations('name'),
            'name_in_match' => (array)$this->getTranslations('name_in_match'),
            'first_name' => (array)$this->getTranslations('first_name'),
            'last_name' => (array)$this->getTranslations('last_name'),
            'short_name' => (array)$this->getTranslations('short_name'),
            't_shirt' => (string)$this->t_shirt,
            'price' => (float)$this->price,
            'position' => (string)$this->position?->value,
            'playing_status' => (string)$this->player_status?->value,
            'active_season_points_sum_points' => (int)$this->total_player_points, //TODO::fix total points
            'goals_sum_event_value' => (int)$this->goals_sum_event_value,  //TODO:FIX,
            'img' => (string)$this->fileUrl,
            'club' => $this->current_club ? [
                'id' => $this->current_club?->id,
                'name' => $this->current_club?->getTranslations('name'),
            ] : null,
            'created_at' => $this->created_at,

        ];
    }
}
