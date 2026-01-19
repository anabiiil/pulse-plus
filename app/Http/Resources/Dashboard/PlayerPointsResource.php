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

class PlayerPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $player = $this->player;
        $week_id = $this->fixture?->week_id;
        return [
            'id' => $player->id,
            'title' => $player?->name_in_match . ' - ' . $player?->position?->value,
            'name' => $player?->name_in_match,
            'price' => (float)$player->price,
            'position' => $this->position,
            'type' => $this->type,
            'status' => $this->status,
            'player_position' => (string)$player->position?->value,
            'playing_status' => (string)$player->player_status?->value,
            'week_points' => (int)$player->activeSeasonPoints()->where('week_id', $week_id)->sum('points'),
            'bonus' => (int)$player->activeSeasonPoints()->where('week_id', $week_id)->where('event_type', 'bonus')->sum('points'),
            'img' => (string)$player->fileUrl,

        ];
    }
}
