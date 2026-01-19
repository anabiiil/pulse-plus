<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image ? url($this->image) : null,
            'calories' => $this->calories,
            'meal_type' => $this->meal_type,
            'protein_amount' => $this->protein_amount,
            'carb_amount' => $this->carb_amount,
            'fat_amount' => $this->fat_amount,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'pivot' => $this->when($this->pivot, [
                'meal_type' => $this->pivot?->meal_type,
                'sort_order' => $this->pivot?->sort_order,
            ]),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}

