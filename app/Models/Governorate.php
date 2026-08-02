<?php

namespace App\Models;

use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Models\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public $timestamps = true;

    public array $translatable = ['name'];

    protected $fillable = ['name', 'delivery_price', 'status'];

    protected $casts = [
        'status' => StatusEnum::class,
        'delivery_price' => 'decimal:2',
    ];
}
