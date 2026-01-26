<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\CreateServiceRequest;
use App\Http\Resources\Dashboard\ServiceResource;
use App\Models\File;
use App\Models\Service;
use App\Services\Image\ImageProcessor;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'name' => 'name',
        'id' => 'id',
        'status' => 'status',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    public function __construct(protected ImageProcessor $imageProcessor) {}

    /**
     * Display a listing of services with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Service::count() : $perPage;

        $services = Service::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([ServiceResource::collection($services)]);
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(CreateServiceRequest $request): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $service = Service::create($request->validated());

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $this->extracted($request, $service);
            }

            return $this->responseData(new ServiceResource($service), 201);
        });
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new ServiceResource($service));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(CreateServiceRequest $request, Service $service): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request, $service) {
            $service->update($request->validated());

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldImage = $service->image()->first();
                if ($oldImage) {
                    $oldImage->delete();
                }

                $this->extracted($request, $service);
            }

            return $this->responseData(new ServiceResource($service));
        });
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($service) {
            // Delete associated image if exists
            $image = $service->image()->first();
            if ($image) {
                $image->delete();
            }

            $service->delete();

            return $this->responseData([], msg: 'service deleted successfully');
        });
    }

    public function extracted(CreateServiceRequest $request, $service): void
    {
        $imageInfo = $this->imageProcessor
            ->load($request->file('image'))
            ->convert('webp')
            ->compress(85)
            ->saveAndGetInfo('services', 'public');

        File::create([
            'file_name' => basename($imageInfo['path']),
            'original_name' => $imageInfo['filename'],
            'mime_type' => $imageInfo['mime_type'],
            'collection_name' => 'image',
            'type' => 'image',
            'storage' => 'public',
            'url' => $imageInfo['url'],
            'path' => $imageInfo['path'],
            'size' => $imageInfo['size'],
            'file_id' => $service->id,
            'file_type' => Service::class,
        ]);
    }
}
