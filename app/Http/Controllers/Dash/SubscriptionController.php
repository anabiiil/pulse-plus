<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscription\CreateSubscriptionRequest;
use App\Http\Resources\Dashboard\SubscriptionResource;
use App\Models\Subscription;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'id' => 'id',
        'name' => 'name',
        'months' => 'months',
        'status' => 'status',
        'created_at' => 'created_at',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of subscriptions with filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');
        $forUser = (bool) $request->get('for_user', false);

        $perPage = $perPage === -1 ? (Subscription::count() ?: self::DEFAULT_PER_PAGE) : $perPage;

        $subscriptions = Subscription::query()
            ->when($forUser, fn ($query) => $query->where('status', true))
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([SubscriptionResource::collection($subscriptions)]);
    }

    /**
     * Store a newly created subscription.
     */
    public function store(CreateSubscriptionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status'] = in_array($data['status'] ?? null, ['1', 1, 'true', true], true);

        $subscription = Subscription::create($data);

        return $this->responseData(new SubscriptionResource($subscription), 201);
    }

    /**
     * Display the specified subscription.
     */
    public function show(Subscription $subscription): JsonResponse
    {
        return $this->responseData(new SubscriptionResource($subscription));
    }

    /**
     * Update the specified subscription.
     */
    public function update(CreateSubscriptionRequest $request, Subscription $subscription): JsonResponse
    {
        $data = $request->validated();

        if (isset($data['status'])) {
            $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
        }

        $subscription->update($data);

        return $this->responseData(new SubscriptionResource($subscription));
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy(Subscription $subscription): JsonResponse
    {
        $subscription->delete();

        return $this->responseData(null, 200, 'Subscription deleted successfully.');
    }
}
