<?php

namespace App\Support\Traits\Models;


use App\Enums\Main\DisableEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasDisable
{
    public function scopeOfDisable($query)
    {
        return $query->where('disable', DisableEnum::DISABLE);
    }

    public function scopeOfEnable($query)
    {
        return $query->where('disable', DisableEnum::ENABLE);
    }
    public function disableText(): Attribute
    {
        return Attribute::make(
            get : fn() => $this->disable->trans(),
        );
    }
}
