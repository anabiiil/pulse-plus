<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type?->value,
            'type_label' => $this->type?->trans(),
            'value' => (float) $this->value,
            'starts_at' => $this->starts_at?->format('Y-m-d'),
            'expires_at' => $this->expires_at?->format('Y-m-d'),
            'is_redeemable' => $this->isRedeemable(),
            'status' => $this->status?->value,
            'status_label' => $this->status?->trans(),
            'orders_count' => $this->when(isset($this->completed_orders_count), fn () => (int) $this->completed_orders_count),
            'created_at' => (string) ($this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null),
        ];
    }
}
