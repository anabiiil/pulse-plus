<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Http\Resources\User\Team\TeamResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends UserResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        // Add additional properties for more detailed data


        return array_merge($data, [
            'favorite_club' => $this->favoriteClubs()->first()?->name,
            'total_points' => (int)$this->total_points ?? 0,
            'week_points' => $this->weekTotalPoints(),
            'team' => $this->team ? new TeamResource($this->team) : null,
        ]);

    }
}
