<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\RankDetailsResource;
use App\Support\Enums\Fixture\ClubFixturePointTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'name' => $this->club?->getTranslations('name'),
            'image' => $this->club?->fileUrl,
            'rank' => (int)$this->rank,
            'matchesPlayed' => (int)$this->matchesPlayed,
            'points' => (int)$this->points,
            'matchesWon' => (int)$this->matchesWon,
            'matchesLost' => (int)$this->matchesLost,
            'matchesDrawn' => (int)$this->matchesDrawn,
            'goalsFor' => (int)$this->goalsFor,
            'goalsAgainst' => (int)$this->goalsAgainst,
            'goaldifference' => $this->goaldifference,
        ];
    }
}
