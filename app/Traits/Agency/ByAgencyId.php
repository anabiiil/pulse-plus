<?php

namespace App\Traits\Agency;


use App\Observers\AgencyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait ByAgencyId
{
    protected function scopeByAgencyId(Builder $query): Builder
    {
        return $query->where('agency_id', auth('vendor-api')->user()->agency_id);
    }
}
