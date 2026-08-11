<?php

namespace App\Models;

use App\Support\Enums\Main\CouponTypeEnum;
use App\Support\Enums\Main\OrderStatusEnum;
use App\Support\Enums\Main\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'type' => CouponTypeEnum::class,
            'value' => 'decimal:2',
            'starts_at' => 'date',
            'expires_at' => 'date',
            'status' => StatusEnum::class,
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Orders that count toward this coupon's statistics (completed only).
     */
    public function completedOrders(): HasMany
    {
        return $this->orders()->where('status', OrderStatusEnum::Completed->value);
    }

    public function isActive(): bool
    {
        return $this->status === StatusEnum::ACTIVE;
    }

    /**
     * Whether the coupon's validity window has started (inclusive by day).
     */
    public function hasStarted(): bool
    {
        return $this->starts_at === null || $this->starts_at->startOfDay()->lte(now());
    }

    /**
     * Whether the coupon has passed its expiry date (inclusive by day).
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->endOfDay()->lt(now());
    }

    /**
     * Whether the coupon can be redeemed right now (active + within its window).
     */
    public function isRedeemable(): bool
    {
        return $this->isActive() && $this->hasStarted() && ! $this->isExpired();
    }

    /**
     * Calculate the discount amount for a given subtotal, capped at the subtotal.
     */
    public function discountFor(float $subtotal): float
    {
        $discount = $this->type === CouponTypeEnum::Percentage
            ? $subtotal * ((float) $this->value / 100)
            : (float) $this->value;

        return round(min($discount, $subtotal), 2);
    }
}
