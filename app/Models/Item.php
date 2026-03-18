<?php

namespace App\Models;

use App\Support\Enums\Item\ItemStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'status',
        'qr_code',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = ['qr_code_path'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ItemStatusEnum::class,
        ];
    }

    /**
     * Get the full public URL to the QR code SVG file.
     */
    public function getQrCodePathAttribute(): ?string
    {
        if (empty($this->qr_code)) {
            return null;
        }

        return asset(Storage::url($this->qr_code));
    }

    /**
     * Check if the QR code file exists in storage.
     */
    public function qrCodeExists(): bool
    {
        if (empty($this->uuid)) {
            return false;
        }

        return Storage::disk('public')->exists('qr-codes/items/'.$this->uuid.'.svg');
    }

    /**
     * Delete the QR code file from storage.
     */
    public function deleteQrCode(): bool
    {
        if (empty($this->uuid)) {
            return false;
        }

        $filePath = 'qr-codes/items/'.$this->uuid.'.svg';

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Item $item): void {
            if (empty($item->uuid)) {
                $item->uuid = (string) Str::uuid();
            }

            if (empty($item->qr_code)) {
                try {
                    $url = app('url')->to('/user/info/'.$item->uuid);

                    $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($url);

                    $directory = storage_path('app/public/qr-codes/items');

                    if (! \File::exists($directory)) {
                        \File::makeDirectory($directory, 0755, true);
                    }

                    $filename = $item->uuid.'.svg';
                    Storage::disk('public')->put('qr-codes/items/'.$filename, $qrCodeSvg);

                    $item->qr_code = 'qr-codes/items/'.$filename;
                } catch (\Exception $e) {
                    \Log::error('Item QR Code generation failed: '.$e->getMessage());
                    $item->qr_code = null;
                }
            }
        });

        static::deleting(function (Item $item): void {
            $item->deleteQrCode();
        });
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
