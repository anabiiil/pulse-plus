<?php

namespace App\Observers;

use App\Models\PlanNutrition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AgencyObserver
{
    /**
     * Handle the model "creating" event.
     * Automatically set agency_id and vendor_id from authenticated vendor.
     */
    public function creating(Model $model): void
    {
        $vendor = Auth::guard('vendor-api')->user();
        if ($vendor) {
            if (!$model->agency_id && isset($model->agency_id)) {
                $model->agency_id = $vendor->agency_id;
            }
            if (!isset($model->vendor_id) || !$model->vendor_id) {
                if (in_array('vendor_id', $model->getFillable())) {
                    $model->vendor_id = $vendor->id;
                }
            }
        }
    }
}

