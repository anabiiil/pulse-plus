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
use Illuminate\Http\UploadedFile;
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
            ->with('attachments')
            ->latest()
            ->when($category, fn ($q) => $q->where('category', $category));

        $files = $query->paginate($perPage);

        app()->setLocale($request->query('lang', app()->getLocale()));

        return $this->responsePaginated([MedicalFileResource::collection($files)]);
    }

    /**
     * Store a new medical file (with a group of attachments) for the user.
     */
    public function store(StoreMedicalFileRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['category'] = $data['category'] ?? MedicalFileCategoryEnum::Analyses->value;

        unset($data['files'], $data['file'], $data['remove_attachment_ids']);

        app()->setLocale($request->query('lang', app()->getLocale()));

        $file = MedicalFile::create($data);

        $this->storeAttachments($file, $this->collectUploads($request));
        $this->syncPrimaryPath($file);

        return $this->responseData(new MedicalFileResource($file->load('attachments')), 201);
    }

    /**
     * Update an existing medical file: edit fields, add and/or remove attachments.
     */
    public function update(StoreMedicalFileRequest $request, MedicalFile $medicalFile): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if ($medicalFile->user_id !== $user->id) {
            return $this->responseError([], code: 403, msg: 'Forbidden.');
        }

        $data = $request->validated();
        unset($data['files'], $data['file'], $data['remove_attachment_ids']);

        app()->setLocale($request->query('lang', app()->getLocale()));

        $medicalFile->update($data);

        // Remove attachments the user chose to delete (only their own)
        $removeIds = $request->input('remove_attachment_ids', []);
        if (! empty($removeIds)) {
            $medicalFile->attachments()->whereIn('id', $removeIds)->get()
                ->each(function ($attachment) {
                    if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                        Storage::disk('public')->delete($attachment->file_path);
                    }
                    $attachment->delete();
                });
        }

        $this->storeAttachments($medicalFile, $this->collectUploads($request));
        $this->syncPrimaryPath($medicalFile->refresh());

        return $this->responseData(new MedicalFileResource($medicalFile->load('attachments')));
    }

    /**
     * Delete a medical file (and all its attachments) owned by the user.
     */
    public function destroy(MedicalFile $medicalFile): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if ($medicalFile->user_id !== $user->id) {
            return $this->responseError([], code: 403, msg: 'Forbidden.');
        }

        foreach ($medicalFile->attachments as $attachment) {
            if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
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

    /**
     * Collect uploaded files from either `files[]` or the legacy single `file`.
     *
     * @return array<int, UploadedFile>
     */
    private function collectUploads(Request $request): array
    {
        $uploads = [];

        if ($request->hasFile('files')) {
            foreach ((array) $request->file('files') as $file) {
                if ($file instanceof UploadedFile) {
                    $uploads[] = $file;
                }
            }
        }

        if ($request->hasFile('file')) {
            $uploads[] = $request->file('file');
        }

        return $uploads;
    }

    /**
     * Persist uploaded files as attachments of the medical record.
     *
     * @param  array<int, UploadedFile>  $uploads
     */
    private function storeAttachments(MedicalFile $medicalFile, array $uploads): void
    {
        foreach ($uploads as $upload) {
            $medicalFile->attachments()->create([
                'file_path' => $upload->store(MedicalFile::FILE_PATH, 'public'),
                'original_name' => $upload->getClientOriginalName(),
            ]);
        }
    }

    /**
     * Keep the record's legacy `file_path` pointing at its first attachment
     * (used as a thumbnail and for backward compatibility).
     */
    private function syncPrimaryPath(MedicalFile $medicalFile): void
    {
        $first = $medicalFile->attachments()->oldest('id')->first();
        $path = $first?->file_path;

        if ($medicalFile->file_path !== $path) {
            $medicalFile->update(['file_path' => $path]);
        }
    }
}
