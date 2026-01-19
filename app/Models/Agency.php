<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'business_name',
        'email',
        'vat_number',
        'phone',
    ];

    public function vendors():HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function nutritionPlans(): HasMany
    {
        return $this->hasMany(PlanNutrition::class);
    }
}
