<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanNutritionResource extends JsonResource
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
            'protein_percentage' => $this->protein_percentage,
            'carb_percentage' => $this->carb_percentage,
            'fats_percentage' => $this->fats_percentage,
            'agency_id' => $this->agency_id,
            'is_active' => $this->is_active,
            'agency' => new AgencyResource($this->whenLoaded('agency')),
            'meals' => MealResource::collection($this->whenLoaded('meals')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}

