<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvatarCategoryResource extends JsonResource
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
            'name' => $this->getTranslations('name'),
            'type' => $this->type,
            'avatars' => $this->whenLoaded('icons', fn() => IconResource::collection($this->icons)),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
    }
}
