<?php

namespace App\Models;

use App\Support\Traits\Image\HasFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasFile, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'video_url',
        'status',
    ];

    /**
     * The attributes that should be translatable.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'name',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the product's image file.
     */
    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(File::class, 'file')->where('collection_name', 'image');
    }

    /**
     * Get an iframe-embeddable URL for the product video.
     *
     * Normalizes common YouTube link formats (watch, youtu.be, shorts, embed)
     * into a https://www.youtube.com/embed/{id} URL. Any other URL is returned as-is.
     */
    protected function videoEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (empty($this->video_url)) {
                    return null;
                }

                if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~i', $this->video_url, $matches)) {
                    return 'https://www.youtube.com/embed/'.$matches[1];
                }

                return $this->video_url;
            },
        );
    }
}
