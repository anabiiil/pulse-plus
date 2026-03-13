<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    /**
     * Get user information by UUID (hash_url)
     */
    public function show(Request $request, $uuid)
    {
        // Detect language from request header or default to Arabic
        $locale = $request->header('Accept-Language', 'ar');
        if (str_contains($locale, 'en')) {
            $locale = 'en';
        } else {
            $locale = 'ar';
        }
        app()->setLocale($locale);

        // Find user by hash_url (UUID)
        $user = User::where('hash_url', $uuid)
            ->with(['country', 'diseases', 'medicalInfo'])
            ->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => __('messages.user_not_found'),
            ], 404);
        }

        // Prepare user data
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'emergency_phone' => $user->emergency_phone,
            'display_emergency' => $user->display_emergency,
            'address' => $user->address,
            'birthdate' => $user->birthdate,
            'gender' => $user->gender,
            'marital_status' => $user->marital_status,
            'profile_image_url' => $user->profile_image_url,
            'qr_code_url' => $user->qr_code_url,
            'country' => $user->country ? [
                'id' => $user->country->id,
                'name' => $user->country->name,
            ] : null,
            'diseases' => $user->diseases->map(fn ($disease) => [
                'id' => $disease->id,
                'name' => $disease->getTranslation('name', app()->getLocale(), useFallbackLocale: true),
            ])->values(),
            'medical_info' => $user->medicalInfo ? [
                'blood_type' => $user->medicalInfo->blood_type?->value,
                'notes' => $user->medicalInfo->notes,
            ] : null,
        ];

        return response()->json([
            'success' => true,
            'data' => $userData,
        ]);
    }
}
