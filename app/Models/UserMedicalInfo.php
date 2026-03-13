<?php

namespace App\Models;

use App\Support\Enums\User\BloodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMedicalInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_medical_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'notes',
        'blood_type',
        'emergency_number',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'blood_type' => BloodTypeEnum::class,
        ];
    }

    /**
     * Get the user that owns the medical info.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
