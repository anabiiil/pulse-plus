<?php

namespace App\Models;

use App\Support\Traits\Image\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasFile, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'desc',
        'status',
    ];

    /**
     * The attributes that should be translatable.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'title',
        'desc',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'title' => 'array',
            'desc' => 'array',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the slider's image file.
     */
    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(File::class, 'file')->where('collection_name', 'image');
    }
}
