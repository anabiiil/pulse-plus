<?php

namespace App\Traits\Auth;

use Illuminate\Support\Facades\Hash;

trait HasCheckPassword
{
    public function checkHashPassword($password): bool
    {
        return Hash::check($password, $this->password);
    }
}
