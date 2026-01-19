<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionMeal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'subscription_id',
        'meal_id',
        'delivery_date',
        'meal_type',
        'base_price',
        'final_price',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivery_date' => 'date',
            'base_price' => 'decimal:2',
            'final_price' => 'decimal:2',
        ];
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopePrepared($query)
    {
        return $query->where('status', 'prepared');
    }

    public function scopeOutForDelivery($query)
    {
        return $query->where('status', 'out_for_delivery');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeByDeliveryDate($query, $date)
    {
        return $query->whereDate('delivery_date', $date);
    }

    public function scopeByMealType($query, string $mealType)
    {
        return $query->where('meal_type', $mealType);
    }

    // Helpers
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isPrepared(): bool
    {
        return $this->status === 'prepared';
    }

    public function isOutForDelivery(): bool
    {
        return $this->status === 'out_for_delivery';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    // Relationships
    /**
     * Get the subscription that owns this meal.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the meal.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}

