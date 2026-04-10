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
            'subscription' => $this->when(
                $this->relationLoaded('latestSubscription') && $this->latestSubscription,
                fn () => [
                    'id' => $this->latestSubscription->id,
                    'subscription_id' => $this->latestSubscription->subscription_id,
                    'subscription_name' => $this->latestSubscription->subscription?->name,
                    'start_date' => $this->latestSubscription->start_date?->toDateString(),
                    'end_date' => $this->latestSubscription->end_date?->toDateString(),
                    'status' => $this->latestSubscription->status->value,
                    'status_label' => $this->latestSubscription->status->label(),
                    'status_color' => $this->latestSubscription->status->color(),
                ]
            ),
            'profile_image' => $this->profile_image,
            'profile_image_url' => $this->profile_image_url,
            'status' => (bool) $this->status,
            'hash_url' => $this->hash_url,
            'qr_code' => $this->qr_code,
            'qr_code_path' => $this->qr_code_path ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
