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

class PlayerLineupResource extends JsonResource
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
            'name' => $this?->name_in_match,
            'title' => $this->name_in_match . ' - ' . $this->position?->value,
            'price' => (float)$this->price,
            'player_position' => (string)$this->position?->value,
            'type' => null,
            'status' => null,
            'position' => null,
            'playing_status' => (string)$this->player_status?->value,
            'img' => (string)$this->fileUrl,
        ];
    }
}
