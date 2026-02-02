<?php

namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function showLoginForm()
    {
        if (auth('web')->check()) {
            return redirect()->to('/profile');
        }
        return view('website.auth.login');
    }

    public function showRegisterForm()
    {
        if (auth('web')->check()) {
            return redirect()->to('/profile');
        }
        return view('website.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard('web')->login($user, $request->boolean('remember'));

            return $this->responseData([
                'user' => auth('web')->user(),
                'redirect' => '/profile'
            ]);
        }

        return $this->responseError([
            'email' => 'Invalid credentials',
        ], code: 422, key: 'errors');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        Auth::guard('web')->login($user);

        return $this->responseData([
            'user' => auth('web')->user(),
            'redirect' => '/profile'
        ], 201);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? $this->responseData(['message' => 'Logged out successfully'])
            : redirect('/');
    }
}
