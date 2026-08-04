<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\OrderResource;
use App\Models\Order;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponseTrait;

    /**
     * List the current user's orders.
     */
    public function index(): JsonResponse
    {
        $orders = Order::query()
            ->where('user_id', auth('web')->id())
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return $this->responsePaginated([OrderResource::collection($orders)]);
    }

    /**
     * Show a single order that belongs to the current user.
     */
    public function show(Order $order): JsonResponse
    {
        abort_unless($order->user_id === auth('web')->id(), 403, 'Forbidden');

        return $this->responseData(new OrderResource($order->load('items')));
    }
}
