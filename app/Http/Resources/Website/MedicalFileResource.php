<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category->value,
            'category_label' => $lang === 'ar'
                ? $this->category->labelAr()
                : $this->category->labelEn(),
            'category_icon' => $this->category->icon(),
            'file_url' => $this->file_url,
            'doctor' => $this->doctor,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toDateString(),
        ];
    }
}
