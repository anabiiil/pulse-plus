<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Item\CreateItemRequest;
use App\Http\Requests\Admin\Item\UpdateItemRequest;
use App\Http\Resources\Dashboard\ItemResource;
use App\Models\Item;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'id' => 'id',
        'name' => 'name',
        'status' => 'status',
        'uuid' => 'uuid',
        'created_at' => 'created_at',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of items with filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Item::count() : (int) $perPage;

        $items = Item::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('uuid', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([ItemResource::collection($items)]);
    }

    /**
     * Store a newly created item.
     */
    public function store(CreateItemRequest $request): JsonResponse
    {
        $item = Item::create($request->validated());

        return $this->responseData(new ItemResource($item), 201);
    }

    /**
     * Display the specified item.
     */
    public function show(Item $item): JsonResponse
    {
        return $this->responseData(new ItemResource($item));
    }

    /**
     * Update the specified item.
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $data = $request->validated();

        if (isset($data['status'])) {
            $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
        }

        $item->update($data);

        return $this->responseData(new ItemResource($item));
    }

    /**
     * Remove the specified item.
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();

        return $this->responseData(null, 200, 'Item deleted successfully.');
    }
}
