<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\CreateSettingRequest;
use App\Http\Resources\Dashboard\SettingResource;
use App\Models\Setting;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SettingController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'title' => 'title',
        'slug' => 'slug',
        'id' => 'id',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of settings with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Setting::count() : $perPage;

        $settings = Setting::query()
            ->when($search, fn ($query) => $query->where('slug', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([SettingResource::collection($settings)]);
    }

    /**
     * Store a newly created setting in storage.
     */
    public function store(CreateSettingRequest $request): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $setting = Setting::create($request->validated());

            return $this->responseData(new SettingResource($setting), 201);
        });
    }

    /**
     * Display the specified setting.
     */
    public function show(Setting $setting): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new SettingResource($setting));
    }

    /**
     * Get a setting by its slug.
     */
    public function getBySlug(string $slug): \Illuminate\Http\JsonResponse
    {
        $setting = Setting::where('slug', $slug)->firstOrFail();

        return $this->responseData(new SettingResource($setting));
    }

    /**
     * Update the specified setting in storage.
     *
     * @throws Throwable
     */
    public function update(CreateSettingRequest $request, Setting $setting): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request, $setting) {
            $setting->update($request->validated());

            return $this->responseData(new SettingResource($setting));
        });
    }

    /**
     * Remove the specified setting from storage.
     *
     * @throws Throwable
     */
    public function destroy(Setting $setting): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($setting) {
            $setting->delete();

            return $this->responseData([], msg: 'Setting deleted successfully');
        });
    }
}

