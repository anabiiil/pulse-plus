<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\CreateSliderRequest;
use App\Http\Resources\Dashboard\SliderResource;
use App\Models\File;
use App\Models\Slider;
use App\Support\Services\Image\ImageService;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SliderController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'title' => 'title',
        'id' => 'id',
        'status' => 'status',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    public function __construct(protected ImageService $imageService) {}

    /**
     * Display a listing of sliders with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Slider::count() : $perPage;

        $sliders = Slider::query()
            ->when($search, fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([SliderResource::collection($sliders)]);
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(CreateSliderRequest $request): \Illuminate\Http\JsonResponse
    {

        return DB::transaction(function () use ($request) {
            $slider = Slider::create($request->validated());
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $this->extracted($request, $slider);
            }

            return $this->responseData(new SliderResource($slider), 201);
        });
    }

    /**
     * Display the specified slider.
     */
    public function show(Slider $slider): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new SliderResource($slider));
    }

    /**
     * Update the specified slider in storage.
     *
     * @throws Throwable
     */
    public function update(CreateSliderRequest $request, Slider $slider): \Illuminate\Http\JsonResponse
    {

        return DB::transaction(function () use ($request, $slider) {
            $data = $request->validated();
            // Convert status to boolean properly
            if (isset($data['status'])) {
                $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
            }

            $slider->update($data);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldImage = $slider->image()->first();
                $oldImage?->delete();

                $this->extracted($request, $slider);
            }

            return $this->responseData(new SliderResource($slider));
        });
    }

    /**
     * Remove the specified slider from storage.
     *
     * @throws Throwable
     */
    public function destroy(Slider $slider): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($slider) {
            // Delete associated image if exists
            $image = $slider->image()->first();
            if ($image) {
                $image->delete();
            }

            $slider->delete();

            return $this->responseData([], msg: 'slider deleted successfully');
        });
    }

    public function extracted(CreateSliderRequest $request, Slider $slider): void
    {
        $imageInfo = $this->imageService->storeImage(
            $request->file('image'),
            'sliders',
            'image',
            'public'
        );

        File::create([
            'file_name' => $imageInfo['file_name'],
            'original_name' => $imageInfo['original_name'],
            'mime_type' => $imageInfo['mime_type'],
            'collection_name' => 'image',
            'type' => 'image',
            'storage' => 'public',
            'url' => $imageInfo['url'],
            'path' => $imageInfo['path'],
            'size' => $imageInfo['size'],
            'file_id' => $slider->id,
            'file_type' => Slider::class,
        ]);
    }
}
