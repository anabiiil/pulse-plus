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

        if (! $user || ! Hash::check($request->password, $user->password)) {
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
            'message' => 'Logout successful',
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        $user = auth('web')->user();

        if (! $user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        $user->load('medicalInfo', 'diseases');

        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'emergency_phone' => $user->emergency_phone,
                'display_emergency' => (bool) $user->display_emergency,
                'birthdate' => $user->birthdate,
                'gender' => $user->gender,
                'address' => $user->address,
                'country_id' => $user->country_id,
                'marital_status' => $user->marital_status,
                'profile_image_url' => $user->profile_image_url,
                'hash_url' => $user->hash_url,
                'medical_info' => $user->medicalInfo ? [
                    'blood_type' => $user->medicalInfo->blood_type?->value,
                    'emergency_number' => $user->medicalInfo->emergency_number,
                    'notes' => $user->medicalInfo->notes,
                ] : null,
                'diseases' => $user->diseases->map(fn ($d) => [
                    'id' => $d->id,
                    'name' => $d->name,
                ])->values(),
            ],
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth('web')->user();

        if (! $user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        // Convert empty strings to null for nullable fields
        $data = $request->all();
        $nullableFields = ['emergency_phone', 'birthdate', 'gender', 'address', 'country_id', 'marital_status'];

        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'display_emergency' => 'nullable|boolean',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'marital_status' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ])->validate();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }

            // Store new image
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $validated['profile_image'] = $path;
        }

        // Remove profile_image from validated if not uploaded to avoid overwriting
        if (! $request->hasFile('profile_image')) {
            unset($validated['profile_image']);
        }

        $user->update($validated);

        return $this->responseData([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'emergency_phone' => $user->emergency_phone,
                'display_emergency' => (bool) $user->display_emergency,
                'birthdate' => $user->birthdate,
                'gender' => $user->gender,
                'address' => $user->address,
                'country_id' => $user->country_id,
                'marital_status' => $user->marital_status,
                'profile_image_url' => $user->profile_image_url,
                'hash_url' => $user->hash_url,
            ],
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $user = auth('web')->user();

        if (! $user) {
            return $this->responseError(['message' => 'Unauthenticated'], code: 401);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return $this->responseData([
            'message' => 'Password changed successfully',
        ]);
    }
}
