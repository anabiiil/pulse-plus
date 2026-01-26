<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\Image\HasFile;

class File extends Model
{
    use HasFactory,
    HasFile;

    protected $fillable = [
        'file_name',
        'original_name',
        'mime_type',
        'collection_name',
        'type',
        'storage',
        'url',
        'path',
        'order_column',
        'size',
        'file_id',
        'file_type'
    ];

    public function file(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
    return $this->morphTo();
    }
}
