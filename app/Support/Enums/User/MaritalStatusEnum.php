<?php

namespace App\Support\Enums\User;

enum MaritalStatusEnum: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';

    /**
     * Get all values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get label for display
     */
    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'أعزب',
            self::MARRIED => 'متزوج',
            self::DIVORCED => 'مطلق',
            self::WIDOWED => 'أرمل',
        };
    }

    /**
     * Get English label
     */
    public function labelEn(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::DIVORCED => 'Divorced',
            self::WIDOWED => 'Widowed',
        };
    }

    /**
     * Get all options as array
     */
    public static function options(): array
    {
        return array_map(
            static fn ($case) => [
                'value' => $case->value,
                'label_ar' => $case->label(),
                'label_en' => $case->labelEn(),
            ],
            self::cases()
        );
    }
}
