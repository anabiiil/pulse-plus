<?php

namespace App\Traits\Agency;


use App\Observers\AgencyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(AgencyObserver::class)]
trait BelongsToAgency
{
    public static function bootBelongsToAgency(): void
    {
        // You can add additional boot logic here if needed
    }
}
