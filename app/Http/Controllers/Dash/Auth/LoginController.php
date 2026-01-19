<?php

namespace App\Http\Controllers\Dash\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ApiResponseTrait;


    public function login()
    {
        if (auth('admin')->check()) {
            return redirect()->to('dash/index');
        }
        return view('dash.pages.auth.login', get_defined_vars());
    }


    public function loginForm(LoginRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::where('email', $data['email'])->first();
        if ($admin && \Hash::check($data['password'], $admin->password)) {
            \Auth::guard('admin')->login($admin);
            return $this->responseData([
                'user' => auth('admin')->user()
            ]);

        } else {
            return $this->responseError([
                'email' => 'invalid data',
            ], code: 422, key: 'errors');
        }
    }
}
