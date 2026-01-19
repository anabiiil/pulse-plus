<?php

namespace App\Support\Enums\File;



use App\Support\Traits\Enums\EnumConverter;

enum FileTypeEnum: string
{
    use EnumConverter;
    case BASIC = 'basic';
    case CLUB_T_SHIRT ='club-t-shirt';
    case ON_BOARDING ='on_boarding';
    case INSTRUCTION_POINT = 'instruction-points';
    case STADIUM = 'stadium';
    case ICON = 'icon';
}
