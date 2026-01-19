<?php

namespace App\Models;

use App\Services\File\FileUploadFactory;
use App\Traits\Agency\BelongsToAgency;
use App\Traits\Agency\ByAgencyId;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PlanNutrition extends Model
{
    use HasFactory, SoftDeletes, BelongsToAgency, ByAgencyId;

    protected $table = 'nutrition_plans';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'protein_percentage',
        'carb_percentage',
        'fats_percentage',
        'agency_id',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        // Delete image when model is being deleted (soft or hard delete)
        static::deleting(static function ($plan) {
            $plan->deleteImage();
        });
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function syncImage(mixed $image): PlanNutrition
    {
        if (!$image) return $this;
        // Handle UploadedFile
        $fileFactory = app(FileUploadFactory::class);
        $processor = $fileFactory->get($image);

        // Process the image
        $image = $processor
            ->load($image)
            ->compress(85)
            ->convert('webp')
            ->deleteImage($this->image)
            ->saveAndGetInfo('nutrition-plans', 'public');

        $this->update(['image' => $image['path']]);
        return $this;
    }

    /**
     * Delete nutrition plan image
     */
    public function deleteImage(): void
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
    }

    /**
     * Sync meals with the nutrition plan
     *
     * @param array $meals Array of meals with format: [['meal_id' => 1, 'meal_type' => 'breakfast', 'sort_order' => 1], ...]
     * @return $this
     */
    public function syncMeals(array $meals): PlanNutrition
    {
        $syncData = [];

        foreach ($meals as $meal) {
            $mealId = $meal['meal_id'] ?? $meal['id'] ?? null;

            if ($mealId) {
                $syncData[$mealId] = [
                    'meal_type' => $meal['meal_type'] ?? 'breakfast',
                    'sort_order' => $meal['sort_order'] ?? 0,
                ];
            }
        }

        $this->meals()->sync($syncData);

        return $this;
    }

    /**
     * Attach a meal for the nutrition plan
     *
     * @param int $mealId
     * @param string $mealType
     * @param int $sortOrder
     * @return $this
     */
    public function attachMeal(int $mealId, string $mealType = 'breakfast', int $sortOrder = 0): PlanNutrition
    {
        $this->meals()->attach($mealId, [
            'meal_type' => $mealType,
            'sort_order' => $sortOrder,
        ]);

        return $this;
    }

    /**
     * Detach a meal from the nutrition plan
     *
     * @param int $mealId
     * @return $this
     */
    public function detachMeal(int $mealId): PlanNutrition
    {
        $this->meals()->detach($mealId);

        return $this;
    }

    /**
     * Update meal pivot data
     *
     * @param int $mealId
     * @param array $attributes
     * @return $this
     */
    public function updateMealPivot(int $mealId, array $attributes): PlanNutrition
    {
        $this->meals()->updateExistingPivot($mealId, $attributes);

        return $this;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relationships
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'nutrition_plan_meals')
            ->withPivot(['meal_type', 'sort_order'])
            ->withTimestamps();
    }

    public function nutritionPlanMeals()
    {
        return $this->hasMany(NutritionPlanMeal::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


}
