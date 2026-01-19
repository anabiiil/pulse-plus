<?php

namespace App\Models;

use App\Enums\VendorType;
use App\Traits\Agency\ByAgencyId;
use App\Traits\Auth\HasCheckPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasCheckPassword, SoftDeletes, ByAgencyId;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'type',
        'phone',
        'agency_id',
        'locale'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'boolean',
            'type' => VendorType::class,
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function scopeOwners($query)
    {
        return $query->where('type', VendorType::OWNER);
    }

    public function scopeEmployees($query)
    {
        return $query->where('type', VendorType::EMPLOYEE);
    }

    // Helpers
    public function isOwner(): bool
    {
        return $this->type === VendorType::OWNER;
    }

    public function isEmployee(): bool
    {
        return $this->type === VendorType::EMPLOYEE;
    }

    public function isActive(): bool
    {
        return $this->status;
    }

    // Relationships
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function nutritionPlans()
    {
        return $this->hasMany(PlanNutrition::class, 'agency_id', 'agency_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

