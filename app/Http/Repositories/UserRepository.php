<?php

namespace App\Http\Repositories;


use App\Models\User;
use App\Support\Repositories\EloquentMainRepository;

class UserRepository extends EloquentMainRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
