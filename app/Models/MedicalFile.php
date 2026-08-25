<?php

namespace App\Models;

use App\Support\Enums\MedicalFile\MedicalFileCategoryEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class MedicalFile extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'file_path',
        'doctor',
        'notes',
    ];

    const FILE_PATH = 'medical-files';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => MedicalFileCategoryEnum::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(MedicalFileAttachment::class);
    }

    public function getFileUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }

    protected $appends = ['file_url'];
}
