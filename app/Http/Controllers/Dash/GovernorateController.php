<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Governorate\CreateGovernorateRequest;
use App\Http\Resources\Dashboard\GovernorateResource;
use App\Models\Governorate;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    use ApiResponseTrait;

    private const SORT_FIELD_MAPPING = [
        'name' => 'name',
        'id' => 'id',
        'status' => 'status',
    ];

    private const DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of governorates with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Governorate::count() : $perPage;

        $governorates = Governorate::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([GovernorateResource::collection($governorates)]);
    }

    /**
     * Store a newly created governorate in storage.
     */
    public function store(CreateGovernorateRequest $request): \Illuminate\Http\JsonResponse
    {
        $governorate = Governorate::create($request->validated());

        return $this->responseData(new GovernorateResource($governorate), 201);
    }

    /**
     * Display the specified governorate.
     */
    public function show(Governorate $governorate): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new GovernorateResource($governorate));
    }

    /**
     * Update the specified governorate in storage.
     */
    public function update(CreateGovernorateRequest $request, Governorate $governorate): \Illuminate\Http\JsonResponse
    {
        $governorate->update($request->validated());

        return $this->responseData(new GovernorateResource($governorate));
    }

    /**
     * Remove the specified governorate from storage.
     */
    public function destroy(Governorate $governorate): \Illuminate\Http\JsonResponse
    {
        $governorate->delete();

        return $this->responseData([], msg: 'governorate deleted successfully');
    }
}
