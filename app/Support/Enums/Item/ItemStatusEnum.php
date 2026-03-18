<?php

namespace App\Support\Enums\Item;

enum ItemStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Used = 'used';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Used => 'Used',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'bg-success',
            self::Inactive => 'bg-warning',
            self::Used => 'bg-primary',
        };
    }

    public function isActive(): bool
    {
        return $this === self::Active;
    }
}
