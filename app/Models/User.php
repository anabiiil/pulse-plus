<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\Enums\File\FileTypeEnum;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Enums\Main\UserStatusEnum;
use App\Support\Enums\Otp\OTPStatusEnum;
use App\Support\Enums\Otp\OTPTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lang',
        'first_name',
        'last_name',
        'email',
        'country_id',
        'phone',
        'dial_code',
        'subscribe_news',
        'password',
        'status',
        'firebase_uid',
        'fcm_token',
        'social_type',
        'type',
        'notification_status',
    ];
    const IMAGE_PATH = 'images/user';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['phone_number', 'full_name'];

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

    protected function getFullNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    protected function getPhoneNumberAttribute(): string
    {
        return $this->dial_code . (int)$this->phone;
    }

    public function otp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->latest();
    }

    public function lastChangeEmailOtp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->where('status', OTPStatusEnum::ACTIVE)->where('type', OTPTypeEnum::CHANGE_MAIL)->latest();
    }


    public function lastValidEmailOtp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->where('status', OTPStatusEnum::ACTIVE)->where('type', OTPTypeEnum::VERIFY_EMAIL)->latest();
    }

    public function lastValidForgetOtp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->where('type', OTPTypeEnum::RESET_PASSWORD)->latest();
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class)->where('status', StatusEnum::ACTIVE)->latest()->where('competition_id', getActiveCompetitionId());
    }

    public function teamBySeason($season_id): HasOne
    {
        return $this->hasOne(Team::class)->where('status', StatusEnum::ACTIVE)->where('season_id', $season_id);
    }

    public function team_management(): HasOne
    {
        return $this->hasOne(TeamManagement::class)->where('status', StatusEnum::ACTIVE);
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(File::class, 'file');
    }

    public function getFileUrlAttribute(): string
    {
        $image = $this?->files()->where('type', FileTypeEnum::BASIC->value)->first();
        if ($image) return $image->storage == 's3' ?
            Storage::disk($image->storage)->temporaryUrl($image?->path, now()->addDay())
            : asset(Storage::disk($image->storage)->url($image?->path));
        return 'https://t3.ftcdn.net/jpg/04/60/01/36/360_F_460013622_6xF8uN6ubMvLx0tAJECBHfKPoNOR5cRa.jpg';
    }


    public function public_leagues(): BelongsToMany
    {
        return $this->belongsToMany(League::class, 'league_teams', 'user_id')->where('type', 'public')->whereNull('club_id')->withPivot(['points', 'current_rank', 'previous_rank', 'user_id', 'league_id']);
    }

    public function public_club_leagues(): BelongsToMany
    {
        return $this->belongsToMany(League::class, 'league_teams', 'user_id')->where('type', 'public')->where('club_id', $this->favoriteClubs()->first()?->id)->withPivot(['points', 'current_rank', 'previous_rank', 'user_id', 'league_id']);
    }

    public function private_leagues(): BelongsToMany
    {
        return $this->belongsToMany(League::class, 'league_teams', 'user_id')->where('type', 'private')->withPivot(['points', 'current_rank', 'previous_rank', 'user_id', 'league_id']);
    }

    public function favoriteClubs(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Club::class, 'fav', 'user_favorite', 'user_id', 'fav_id');
    }


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function favoriteTeams(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Team::class, 'fav', 'user_favorite');
    }

    public function weekPoints(): HasMany
    {
        return $this->hasMany(WeekPoint::class, 'user_id');
    }


    public function totalPoints(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weekPoints()->sum('points'),
        );
    }

    public function weekTotalPoints($week_id = null)
    {
        $week_id = $week_id ?? getCurrentWeekId();
        return $this->weekPoints()->where('week_id', $week_id)->sum('points');
    }
//    public function selectedWeekTotalPoints($week_id)
//    {
//        return $this->playersManagement()->where('main', true)->where('week_id', $week_id)->sum('points');
//    }

    public
    function playersManagement(): HasMany
    {
        return $this->hasMany(TeamManagement::class)->where('team_id', $this->team?->id);
    }


    public function teamPlayers(): HasMany
    {
        return $this->hasMany(TeamPlayer::class, 'user_id');
    }

    public function totalRank(): Attribute
    {
        $users = DB::table('users')
            ->join('user_weeks_points', 'users.id', '=', 'user_weeks_points.user_id')
            ->select('users.id', 'users.first_name', DB::raw('SUM(user_weeks_points.points) as total_points'))
            ->groupBy('users.id')
            ->orderByDesc('total_points')
            ->get();


        $rankedUsers = $users->pluck('id')->toArray();
        $userRank = array_search($this->id, $rankedUsers);
        return Attribute::make(
            get: fn() => !$userRank ? 0 : $userRank,
        );
    }

    public function getHighestPoints(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weekPoints()->orderBy('points', 'desc')->where('type', 'week_points')->first()?->points ?? 0,
        );
    }


    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm(): array|string
    {
        return $this->fcm_token;
    }

    public function calculateWeekPoints($week_id)
    {
        return $this->team?->management_players()->wherePivot('main', true)->wherePivot('week_id', $week_id)->sum('points') ?? 0;
    }


}
