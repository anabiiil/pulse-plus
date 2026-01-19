<?php

namespace App\Support\Enums\Main;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
    case BLOCK = 2;


    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-success',
            self::INACTIVE => 'bg-warning',
            self::BLOCK => 'bg-danger'
        };
    }

    public function trans(): string
    {
        return match ($this) {
            self::ACTIVE => __('lang.active'),
            self::INACTIVE => __('lang.inactive'),
            self::BLOCK => __('lang.block'),
        };
    }
}
