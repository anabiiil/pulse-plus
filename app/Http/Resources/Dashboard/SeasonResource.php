<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeasonResource extends JsonResource
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
            'name' => (array)$this->getTranslations('name'),
            'description' => (array)$this->getTranslations('description'),
            'start_date' => (string)($this->start_date ? Carbon::parse($this->start_date)->format('Y-m-d') : null),
            'end_date' => (string)($this->end_date ? Carbon::parse($this->end_date)->format('Y-m-d') : null),
            'status' => (boolean) $this->status?->value,
        ];
    }
}
