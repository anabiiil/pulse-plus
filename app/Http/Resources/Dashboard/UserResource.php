<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Http\Resources\User\Team\TeamResource;
use App\Livewire\Admin\Competition\Modal\Club;
use Carbon\Carbon;
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
//        $fav = auth('user-api')?->user()?->favoriteClubs()->first();
        return [
            'id' => $this->id,
            'full_name' => $this->first_name ? $this->full_name : '---',
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'team_name' => $this->team?->name,
            'email' => $this->email,
            'phone_number' => $this->phone ? $this->phone_number : null,
            'status' => $this->status?->value,
            'last_login' => $this->last_login,
            'social_type' => $this->social_type ?? 'email',
            'type' => $this->type,
            'image' => $this->fileUrl,
            'country' => $this->country?->getTranslation('name', 'en'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'favorite_club' => new ClubResource($this->favoriteClubs()->first()),
            'hash_url' => (string)$this->hash_url,
            'qr_code' => (string)$this->qr_code,
        ];
    }
}
