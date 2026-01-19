<?php

namespace App\Models;

use App\Services\File\FileUploadFactory;
use App\Traits\Agency\BelongsToAgency;
use App\Traits\Agency\ByAgencyId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Meal extends Model
{
    use HasFactory, SoftDeletes, BelongsToAgency, ByAgencyId;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'calories',
        'meal_type',
        'protein_amount',
        'carb_amount',
        'fat_amount',
        'price',
        'is_active',
        'agency_id',
        'vendor_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'calories' => 'integer',
            'protein_amount' => 'decimal:2',
            'carb_amount' => 'decimal:2',
            'fat_amount' => 'decimal:2',
            'price' => 'decimal:2',
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
        static::deleting(static function ($meal) {
            $meal->deleteImage();
        });
    }

    /**
     * Sync meal image
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function syncImage(mixed $image): Meal
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
            ->saveAndGetInfo('meals', 'public');

        $this->update(['image' => $image['path']]);
        return $this;
    }

    /**
     * Delete meal image
     */
    public function deleteImage(): void
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByMealType($query, string $mealType)
    {
        return $query->where('meal_type', $mealType);
    }

    // Relationships
    /**
     * Get the agency that owns the meal.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get the vendor that created the meal.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the nutrition plans that include this meal.
     */
    public function nutritionPlans(): BelongsToMany
    {
        return $this->belongsToMany(PlanNutrition::class, 'nutrition_plan_meals')
            ->withPivot(['meal_type', 'sort_order'])
            ->withTimestamps();
    }

    /**
     * Get the subscription meals for this meal.
     */
    public function subscriptionMeals(): HasMany
    {
        return $this->hasMany(SubscriptionMeal::class);
    }
}

