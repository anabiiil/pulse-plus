<?php

namespace App\Http\Repositories;

use App\Models\Slider;
use App\Support\Repositories\EloquentMainRepository;

class SliderRepository  extends EloquentMainRepository
{
    public function __construct(Slider $model)
    {
        parent::__construct($model);
    }

}
