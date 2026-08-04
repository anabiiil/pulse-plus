<?php

namespace App\Models;

use App\Support\Traits\Image\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Translatable\HasTranslations;

class PaymentMethod extends Model
{
    use HasFactory;
    use HasFile;
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_system',
        'is_active',
        'requires_receipt',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'is_system' => 'boolean',
            'is_active' => 'boolean',
            'requires_receipt' => 'boolean',
        ];
    }

    /**
     * Get the payment method's image file.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(File::class, 'file')->where('collection_name', 'image');
    }
}
