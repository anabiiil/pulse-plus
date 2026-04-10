<?php

namespace App\Support\Enums\MedicalFile;

enum MedicalFileCategoryEnum: string
{
    case Analyses = 'analyses';
    case Xrays = 'xrays';
    case Prescriptions = 'prescriptions';
    case Reports = 'reports';

    public function labelAr(): string
    {
        return match ($this) {
            self::Analyses => 'تحاليل',
            self::Xrays => 'أشعة',
            self::Prescriptions => 'روشتات',
            self::Reports => 'تقارير طبية',
        };
    }

    public function labelEn(): string
    {
        return match ($this) {
            self::Analyses => 'Analyses',
            self::Xrays => 'X-rays',
            self::Prescriptions => 'Prescriptions',
            self::Reports => 'Medical Reports',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Analyses => 'pi-heart-fill',
            self::Xrays => 'pi-search',
            self::Prescriptions => 'pi-file-edit',
            self::Reports => 'pi-file',
        };
    }
}
