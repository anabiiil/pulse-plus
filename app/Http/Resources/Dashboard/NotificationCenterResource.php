<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Http\Resources\User\Team\TeamResource;
use App\Livewire\Admin\Competition\Modal\Club;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationCenterResource extends JsonResource
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
            'title' => $this->title,
            'desc' => $this->desc,
            'type' => $this->type,
            'status' => $this->status,
            'users_ids' => $this->users_ids,
            'send_date' => Carbon::parse($this->send_date)->setTimezone('Asia/Riyadh')->format('Y-m-d H:i:s'),
        ];
    }
}
