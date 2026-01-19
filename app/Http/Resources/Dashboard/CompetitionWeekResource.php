<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\ClubResource;
use App\Http\Resources\User\Team\TeamResource;
use App\Livewire\Admin\Competition\Modal\Club;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetitionWeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (integer)$this->id,
            'name' => $this->getTranslations('name'),
            'current' => $this->current,
        ];
    }
}
