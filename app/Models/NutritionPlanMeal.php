<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionPlanMeal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nutrition_plan_meals';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nutrition_plan_id',
        'meal_id',
        'meal_type',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    // Relationships
    /**
     * Get the nutrition plan that owns this meal association.
     */
    public function nutritionPlan(): BelongsTo
    {
        return $this->belongsTo(PlanNutrition::class);
    }

    /**
     * Get the meal.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}

