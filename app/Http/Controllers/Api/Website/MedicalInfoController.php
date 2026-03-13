<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\UpdateMedicalInfoRequest;
use App\Http\Resources\Website\DiseaseResource;
use App\Models\Disease;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicalInfoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all chronic diseases filtered by language.
     */
    public function diseases(Request $request): JsonResponse
    {
        $lang = $request->query('lang', app()->getLocale());

        app()->setLocale($lang);

        $diseases = Disease::orderBy('id')->get();

        return $this->responseData([
            'diseases' => DiseaseResource::collection($diseases),
        ]);
    }

    /**
     * Update the authenticated user's medical info and sync their chronic diseases.
     */
    public function updateMedicalInfo(UpdateMedicalInfoRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        // Update emergency phone and display toggle on the User record
        $userFields = array_filter([
            'emergency_phone'   => $request->input('emergency_phone'),
            'display_emergency' => $request->input('display_emergency'),
        ], fn ($v) => ! is_null($v));

        if (! empty($userFields)) {
            $user->update($userFields);
        }

        // Update or create medical info record (blood type, notes only)
        $medicalInfo = $user->medicalInfo()->firstOrNew();
        $medicalInfo->fill($request->only(['blood_type', 'notes']));
        $medicalInfo->save();

        // Sync chronic diseases if provided
        if ($request->has('disease_ids')) {
            $user->diseases()->sync($request->input('disease_ids', []));
        }

        $user->load('diseases');

        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return $this->responseData([
            'emergency_phone'   => $user->emergency_phone,
            'display_emergency' => (bool) $user->display_emergency,
            'medical_info'      => [
                'blood_type' => $medicalInfo->blood_type?->value,
                'notes'      => $medicalInfo->notes,
            ],
            'diseases' => DiseaseResource::collection($user->diseases),
            'message'  => 'Medical information updated successfully.',
        ]);
    }
}
