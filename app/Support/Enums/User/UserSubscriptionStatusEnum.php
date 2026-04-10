<?php

namespace App\Support\Enums\User;

enum UserSubscriptionStatusEnum: string
{
    case Active = 'active';
    case Ended = 'ended';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Ended => 'Ended',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'bg-success',
            self::Ended => 'bg-secondary',
        };
    }
}
