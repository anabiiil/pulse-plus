<?php

namespace App\Models;

use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Models\HasStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory;
    use HasStatus;
    use HasTranslations;

    public $timestamps = false;
    public array $translatable = ['name'];

    protected $fillable = ['name', 'status'];

    protected $casts = ['status' => StatusEnum::class];

}
