<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Enums\User\UserSubscriptionStatusEnum;
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

        // Find user by the assigned item's UUID
        $user = User::whereHas('item', fn ($q) => $q->where('uuid', $uuid))
            ->with(['country', 'diseases', 'medicalInfo', 'medicalFiles', 'latestSubscription'])
            ->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => __('messages.user_not_found'),
            ], 404);
        }

        $hasActiveSubscription = $user->latestSubscription?->status === UserSubscriptionStatusEnum::Active;

        // Prepare user data
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'emergency_phone' => $user->display_emergency ? $user->emergency_phone : null,
            'display_emergency' => $user->display_emergency,
            'display_medical_profile' => $user->display_medical_profile,
            'display_medical_archive' => $user->display_medical_archive,
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
            'medical_files' => ($hasActiveSubscription && $user->display_medical_archive)
                ? $user->medicalFiles->map(fn ($file) => [
                    'id' => $file->id,
                    'title' => $file->title,
                    'category' => $file->category?->value,
                    'doctor' => $file->doctor,
                    'notes' => $file->notes,
                    'file_url' => $file->file_url,
                ])->values()
                : [],
        ];

        return response()->json([
            'success' => true,
            'data' => $userData,
        ]);
    }
}
