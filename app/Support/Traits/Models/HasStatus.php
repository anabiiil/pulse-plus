<?php

namespace App\Support\Traits\Models;



use App\Support\Enums\Main\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatus
{
    public function scopeActive($query)
    {
        return $query->where('status',StatusEnum::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status',StatusEnum::INACTIVE);
    }
//    public function statusText(): Attribute
//    {
//        return Attribute::make(
//            get : fn() => $this->status->trans(),
//        );
//    }
}
