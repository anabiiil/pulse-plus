<?php

namespace App\Http\Resources;

use App\Http\Resources\User\Team\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fav = auth('user-api')?->user()?->favoriteClubs()->first();
        return [
            'id' => (int)$this->id,
            'full_name' => (string)$this->full_name,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'image' => (string)$this->fileUrl,
            'email' => (string)$this->email,
            'social_type' => (string)$this->social_type,
            'phone' => (string)$this->phone,
            'dial_code' => (string)$this->dial_code,
            'phone_number' => (string)$this->phone_number,
            'subscribe_news' => (boolean)$this->subscribe_news,
            'status' => (boolean)$this->status,
            'country' => new CountryResource($this->country),
            'team' => (string)$this->team?->name,
            'favorite_club' => $fav ? new ClubResource($fav) : null,
            'total_points' => (int)$this->total_points ?? 0,
        ];
    }
}
