<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreMedicalFileRequest;
use App\Http\Resources\Website\MedicalFileResource;
use App\Models\MedicalFile;
use App\Support\Enums\MedicalFile\MedicalFileCategoryEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalFileController extends Controller
{
    use ApiResponseTrait;

    /**
     * List the authenticated user's medical files, optionally filtered by category.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $category = $request->query('category');
        $perPage = (int) $request->query('per_page', 12);

        $query = $user->medicalFiles()
            ->latest()
            ->when($category, fn ($q) => $q->where('category', $category));

        $files = $query->paginate($perPage);

        app()->setLocale($request->query('lang', app()->getLocale()));

        return $this->responsePaginated([MedicalFileResource::collection($files)]);
    }

    /**
     * Store a new medical file for the authenticated user.
     */
    public function store(StoreMedicalFileRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['category'] = $data['category'] ?? MedicalFileCategoryEnum::Analyses->value;

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store(MedicalFile::FILE_PATH, 'public');
        }

        unset($data['file']);

        app()->setLocale($request->query('lang', app()->getLocale()));

        $file = MedicalFile::create($data);

        return $this->responseData(new MedicalFileResource($file), 201);
    }

    /**
     * Update an existing medical file owned by the authenticated user.
     */
    public function update(StoreMedicalFileRequest $request, MedicalFile $medicalFile): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if ($medicalFile->user_id !== $user->id) {
            return $this->responseError([], code: 403, msg: 'Forbidden.');
        }

        $data = $request->validated();

        if ($request->hasFile('file')) {
            // Delete old file
            if ($medicalFile->file_path && Storage::disk('public')->exists($medicalFile->file_path)) {
                Storage::disk('public')->delete($medicalFile->file_path);
            }
            $data['file_path'] = $request->file('file')->store(MedicalFile::FILE_PATH, 'public');
        }

        unset($data['file']);

        app()->setLocale($request->query('lang', app()->getLocale()));

        $medicalFile->update($data);

        return $this->responseData(new MedicalFileResource($medicalFile));
    }

    /**
     * Delete a medical file owned by the authenticated user.
     */
    public function destroy(MedicalFile $medicalFile): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if ($medicalFile->user_id !== $user->id) {
            return $this->responseError([], code: 403, msg: 'Forbidden.');
        }

        if ($medicalFile->file_path && Storage::disk('public')->exists($medicalFile->file_path)) {
            Storage::disk('public')->delete($medicalFile->file_path);
        }

        $medicalFile->delete();

        return $this->responseData([], msg: 'File deleted successfully.');
    }

    /**
     * Return the list of available categories.
     */
    public function categories(Request $request): JsonResponse
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        $categories = array_map(fn (MedicalFileCategoryEnum $c) => [
            'value' => $c->value,
            'label' => $lang === 'ar' ? $c->labelAr() : $c->labelEn(),
            'icon' => $c->icon(),
        ], MedicalFileCategoryEnum::cases());

        return $this->responseData(['categories' => $categories]);
    }
}
