<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Http\Resources\User\Team\TeamResource;
use App\Livewire\Admin\Competition\Modal\Club;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->fileUrl,
            'icon_category_id' => $this->icon_category_id,
        ];
    }
}
