<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoachResource extends JsonResource
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
            'image' => $this->file_url,
            'first_name' => $this->getTranslations('first_name'),
            'last_name' => $this->getTranslations('last_name'),
            'country' => $this->country ? [
                'id' => $this->country?->id,
                'name' => $this->country?->name,
            ] :null,

            'club' => $this->club ? [
                'id' => $this->club?->id,
                'name' => $this->club?->name,
            ] :null,

            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
