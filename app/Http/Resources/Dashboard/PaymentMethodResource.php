<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'code' => $this->code,
            'name' => (array) $this->getTranslations('name'),
            'name_en' => (string) $this->getTranslation('name', 'en'),
            'name_ar' => (string) $this->getTranslation('name', 'ar'),
            'description' => (array) $this->getTranslations('description'),
            'description_en' => (string) $this->getTranslation('description', 'en'),
            'description_ar' => (string) $this->getTranslation('description', 'ar'),
            'is_system' => (bool) $this->is_system,
            'is_active' => (bool) $this->is_active,
            'requires_receipt' => (bool) $this->requires_receipt,
            'image_url' => $this->image?->file_url,
            'created_at' => (string) ($this->created_at?->format('Y-m-d H:i:s')),
        ];
    }
}
