<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'country_id' => $this->country_id,
            'country' => $this->country ? [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ] : null,
            'item_id' => $this->item_id,
            'item' => $this->when($this->relationLoaded('item') && $this->item, fn () => [
                'id' => $this->item->id,
                'uuid' => $this->item->uuid,
                'name' => $this->item->name,
                'status' => $this->item->status->value,
                'qr_code_path' => $this->item->qr_code_path,
            ]),
            'status' => (bool) $this->status,
            'hash_url' => $this->hash_url,
            'qr_code' => $this->qr_code,
            'qr_code_path' => $this->qr_code_path ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
