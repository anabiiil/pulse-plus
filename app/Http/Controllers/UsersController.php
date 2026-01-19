<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
//    public function users()
//    {
//        $users = User::take(100)->get();
//
//        foreach ($users as $user) {
//            if ($user->email) {
//                $status = $this->checkEmailDomain($user->email);
//                if ($status){
//
//                }
//            }
//
//        }
//    }
//
//
//    public function checkEmailDomain($email)
//    {
//        try {
//            $domain = substr(strrchr($email, "@"), 1);
//            return checkdnsrr($domain, 'MX');
//        } catch (\Exception $e) {
//
//        }
//
//
//    }
}
