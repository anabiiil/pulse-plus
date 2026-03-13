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

        // Update or create medical info record
        $medicalInfo = $user->medicalInfo()->firstOrNew();
        $medicalInfo->fill($request->only(['blood_type', 'emergency_number', 'notes']));
        $medicalInfo->save();

        // Sync chronic diseases if provided
        if ($request->has('disease_ids')) {
            $user->diseases()->sync($request->input('disease_ids', []));
        }

        $user->load('diseases');

        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return $this->responseData([
            'medical_info' => [
                'blood_type' => $medicalInfo->blood_type,
                'emergency_number' => $medicalInfo->emergency_number,
                'notes' => $medicalInfo->notes,
            ],
            'diseases' => DiseaseResource::collection($user->diseases),
            'message' => 'Medical information updated successfully.',
        ]);
    }
}
