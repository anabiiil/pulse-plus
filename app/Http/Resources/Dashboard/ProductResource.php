<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'price' => $this->price,
            'video_url' => $this->video_url,
            'video_embed_url' => $this->video_embed_url,
            'is_featured' => (bool) $this->is_featured,
            'status' => (bool) $this->status,
            'image_url' => $this->image?->url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
