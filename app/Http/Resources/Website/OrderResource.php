<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'status' => $this->status?->value,
            'status_label' => $this->status?->trans(),
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'governorate_name' => $this->governorate_name,
            'address' => $this->address,
            'shipping_method' => $this->shipping_method,
            'shipping_price' => (float) $this->shipping_price,
            'payment_method_name' => $this->resolvePaymentName(app()->getLocale()),
            'payment_method_code' => $this->payment_method_code,
            'payment_method_image' => $this->payment_method_image,
            'receipt_url' => $this->receipt_url,
            'coupon_code' => $this->coupon_code,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'total' => (float) $this->total,
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'id' => (int) $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_price' => (float) $item->product_price,
                'quantity' => (int) $item->quantity,
                'line_total' => (float) $item->line_total,
            ])),
            'created_at' => (string) ($this->created_at?->format('Y-m-d H:i:s')),
        ];
    }

    /**
     * Resolve the payment method name snapshot for a given locale.
     */
    private function resolvePaymentName(string $locale): ?string
    {
        $name = $this->payment_method_name;

        if (is_array($name)) {
            return $name[$locale] ?? $name['en'] ?? $name['ar'] ?? null;
        }

        return $name;
    }
}
