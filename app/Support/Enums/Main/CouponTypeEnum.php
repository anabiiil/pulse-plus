<?php

namespace App\Support\Enums\Main;

enum CouponTypeEnum: string
{
    case Percentage = 'percentage';
    case Fixed = 'fixed';

    public function trans(): string
    {
        return match ($this) {
            self::Percentage => 'Percentage',
            self::Fixed => 'Fixed Amount',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Percentage => 'bg-info',
            self::Fixed => 'bg-primary',
        };
    }
}
