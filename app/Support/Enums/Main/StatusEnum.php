<?php

namespace App\Support\Enums\Main;

enum StatusEnum: int
{

    case ACTIVE = 1;
    case INACTIVE = 0;


    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'bg-success',
            self::INACTIVE => 'bg-warning',
        };
    }

    public function trans(): string
    {
        return match ($this) {
            self::ACTIVE => "Active",
            self::INACTIVE => "Inactive",
        };
    }
}
