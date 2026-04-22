<?php

namespace App\Support\Enums\Item;

enum ItemTypeEnum: string
{
    case C = 'C';
    case N = 'N';
    case B = 'B';
    case D = 'D';

    public function label(): string
    {
        return match ($this) {
            self::C => 'C',
            self::N => 'N',
            self::B => 'B',
            self::D => 'D',
        };
    }
}
