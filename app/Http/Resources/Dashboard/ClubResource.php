<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
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
            'stadium' => (array)$this->getTranslations('stadium'),
            'img' => $this->fileUrl,
            't_shirt' => $this->tShirtUrl,
            'code' => $this->code,
            'official_name' => $this->official_name,
            'status' => $this->status?->value,
            'coach' => $this->coach ? [
                'id' => $this->coach?->id,
                'name' => $this->coach?->fullName,
            ] : null,
            'country' => [
                'id' => $this->country?->id,
                'name' => $this->country?->name,
            ],
            'created_at' => (string)($this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d') : null),
        ];
    }
}
