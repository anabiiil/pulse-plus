<?php

namespace App\Http\Repositories;


use App\Models\Admin;
use App\Support\Repositories\EloquentMainRepository;

class AdminRepository extends EloquentMainRepository
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

}
