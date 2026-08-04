<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Models\Order;
use App\Support\Enums\Main\OrderStatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
    use ApiResponseTrait;

    private const SORT_FIELD_MAPPING = [
        'id' => 'id',
        'total' => 'total',
        'status' => 'status',
        'created_at' => 'created_at',
    ];

    private const DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of orders (newest first), optionally filtered by status.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');
        $status = $request->get('status');

        $perPage = $perPage === -1 ? Order::count() : $perPage;

        $orders = Order::query()
            ->withCount('items')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            }))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([OrderResource::collection($orders)]);
    }

    /**
     * Display the specified order with its items.
     */
    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new OrderResource($order->load(['items', 'user'])));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', new Enum(OrderStatusEnum::class)],
        ]);

        $order->update(['status' => $validated['status']]);

        return $this->responseData(new OrderResource($order->load('items')), msg: 'order status updated');
    }

    /**
     * Order status counts (for dashboard stat cards).
     */
    public function statistics(): \Illuminate\Http\JsonResponse
    {
        $counts = [
            'total' => Order::count(),
        ];

        foreach (OrderStatusEnum::cases() as $case) {
            $counts[$case->value] = Order::where('status', $case->value)->count();
        }

        return $this->responseData($counts);
    }
}
