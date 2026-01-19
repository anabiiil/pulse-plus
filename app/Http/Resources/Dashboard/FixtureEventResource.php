<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FixtureEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'event_minute' => (string)$this->match_time_min,
            'event_type' => (string)$this->event_name,
            'event_name' => (string)$this->event_name,
            'event_img' => (string)$this->imageUrl,
            'event_club' => (string)$this->club_id == $this->fixture?->home_club_id ? 'home_club' : 'away_club',
            'event_line_one' => (string)$this->player?->name_in_match,
            'assist_id' => $this->extra_data['player_in_id'] ?? $this->extra_data['assist_id'] ?? null,
            'player_id' => (int)$this->player?->id,
            'fixture_id' => (int)$this->fixture_id,
            'event_line_two' => (string)$this->getLineTwoEvent($this),
        ];
    }

    private function getLineTwoEvent(mixed $event)
    {
        return match ($event->event_name) {
            'substitute' => Player::find($event->extra_data['player_in_id'])?->name_in_match,
            'goal' => Player::find($event->extra_data['assist_id'])?->name_in_match,
            default => '',
        };

    }
}
