<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\Enums\Main\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'birthdate',
        'gender',
        'country_id',
        'marital_status',
        'password',
        'status',
        'type',
        'hash_url',
        'qr_code',
    ];

    const IMAGE_PATH = 'images/user';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['qr_code_path'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatusEnum::class,
        ];
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(File::class, 'file');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the medical information for the user.
     */
    public function medicalInfo(): HasOne
    {
        return $this->hasOne(UserMedicalInfo::class);
    }

    /**
     * Get the diseases associated with the user.
     */
    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'user_diseases');
    }

    /**
     * Get the full file system path of the QR code.
     */
    public function getQrCodePathAttribute(): ?string
    {
        if (empty($this->hash_url)) {
            return null;
        }

        return asset(Storage::url('qr-codes/'.$this->hash_url.'.svg'));
    }

    /**
     * Check if QR code file exists.
     */
    public function qrCodeExists(): bool
    {
        if (empty($this->hash_url)) {
            return false;
        }

        $filePath = 'qr-codes/'.$this->hash_url.'.svg';

        return \Storage::disk('public')->exists($filePath);
    }

    /**
     * Get QR code file size in bytes.
     */
    public function getQrCodeSize(): ?int
    {
        if (! $this->qrCodeExists()) {
            return null;
        }

        $filePath = 'qr-codes/'.$this->hash_url.'.svg';

        return \Storage::disk('public')->size($filePath);
    }

    /**
     * Delete QR code file from storage.
     */
    public function deleteQrCode(): bool
    {
        if (empty($this->hash_url)) {
            return false;
        }

        $filePath = 'qr-codes/'.$this->hash_url.'.svg';

        if (\Storage::disk('public')->exists($filePath)) {
            return \Storage::disk('public')->delete($filePath);
        }

        return false;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            // Generate UUID if not set
            if (empty($user->hash_url)) {
                $user->hash_url = \Illuminate\Support\Str::uuid();
            }

            // Generate QR code as SVG file and save path
            if (empty($user->qr_code)) {
                try {
                    // Build the URL: app('url')/user/info/{uuid}
                    $url = app('url')->to('/user/info/'.$user->hash_url);

                    // Generate QR code as SVG using SimpleSoftwareIO package
                    $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($url);

                    // Create directory if it doesn't exist
                    $qrCodePath = 'qr-codes';
                    $fullPath = storage_path('app/public/'.$qrCodePath);

                    if (!\File::exists($fullPath)) {
                        \File::makeDirectory($fullPath, 0755, true);
                    }

                    // Generate unique filename
                    $filename = $user->hash_url.'.svg';

                    // Save SVG file to storage
                    Storage::disk('public')->put("qr-codes/$filename", $qrCodeSvg);

                    // Store the relative path (not full URL)
                    $user->qr_code = "qr-codes/$filename";
                } catch (\Exception $e) {
                    \Log::error('QR Code generation failed: '.$e->getMessage());
                    // Set null if generation fails
                    $user->qr_code = null;
                }
            }
        });

        // Automatically delete QR code file when user is deleted
        static::deleting(function (User $user) {
            $user->deleteQrCode();
        });
    }
}
