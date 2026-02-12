<?php

namespace App\Http\Controllers\Api\Website;

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

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Login the user
        Auth::guard('web')->login($user, $request->boolean('remember', false));

        // Create API token (if using Sanctum for API authentication)
        // $token = $user->createToken('web-auth')->plainTextToken;

        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'message' => 'Login successful',
            // 'token' => $token, // Uncomment if using Sanctum
        ]);
    }


    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Revoke all tokens (if using Sanctum)
        // $request->user()?->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->responseData([
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        $user = auth('web')->user();

        if (!$user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth('web')->user();

        if (!$user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'message' => 'Profile updated successfully'
        ]);
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $user = auth('web')->user();

        if (!$user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return $this->responseData([
            'message' => 'Password changed successfully'
        ]);
    }
}

