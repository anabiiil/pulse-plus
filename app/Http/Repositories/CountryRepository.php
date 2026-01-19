<?php

namespace App\Http\Repositories;


use App\Models\Country;
use App\Support\Repositories\EloquentMainRepository;

class CountryRepository extends EloquentMainRepository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

}
