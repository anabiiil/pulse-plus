<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CouponRequest;
use App\Http\Resources\Dashboard\CouponResource;
use App\Http\Resources\Dashboard\OrderResource;
use App\Models\Coupon;
use App\Support\Enums\Main\OrderStatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ApiResponseTrait;

    private const SORT_FIELD_MAPPING = [
        'id' => 'id',
        'code' => 'code',
        'value' => 'value',
        'status' => 'status',
        'created_at' => 'created_at',
    ];

    private const DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of coupons with completed-order counts.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Coupon::count() : $perPage;

        $coupons = Coupon::query()
            ->withCount('completedOrders')
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            }))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([CouponResource::collection($coupons)]);
    }

    /**
     * Store a newly created coupon.
     */
    public function store(CouponRequest $request): JsonResponse
    {
        $coupon = Coupon::create($this->normalized($request));

        return $this->responseData(new CouponResource($coupon), 201, 'coupon created successfully');
    }

    /**
     * Display the specified coupon with its completed-order statistics.
     */
    public function show(Coupon $coupon): JsonResponse
    {
        return $this->responseData([
            'coupon' => new CouponResource($coupon),
            'statistics' => $this->buildStatistics($coupon),
        ]);
    }

    /**
     * Update the specified coupon.
     */
    public function update(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        $coupon->update($this->normalized($request));

        return $this->responseData(new CouponResource($coupon), msg: 'coupon updated successfully');
    }

    /**
     * Remove the specified coupon.
     */
    public function destroy(Coupon $coupon): JsonResponse
    {
        $coupon->delete();

        return $this->responseData([], msg: 'coupon deleted successfully');
    }

    /**
     * Completed-order statistics for a single coupon.
     */
    public function statistics(Coupon $coupon): JsonResponse
    {
        return $this->responseData($this->buildStatistics($coupon));
    }

    /**
     * Paginated list of the coupon's orders, optionally filtered by status.
     *
     * The `status` query accepts a single status or a comma-separated list
     * (e.g. "canceled,canceled_by_client"); omit it to list every order.
     */
    public function orders(Request $request, Coupon $coupon): JsonResponse
    {
        $statuses = array_filter(explode(',', (string) $request->get('status', '')));

        $query = $coupon->orders()
            ->withCount('items')
            ->when($statuses, fn ($q) => $q->whereIn('status', $statuses))
            ->orderByDesc('id');

        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        $perPage = $perPage === -1 ? (clone $query)->count() : $perPage;

        return $this->responsePaginated([OrderResource::collection($query->paginate($perPage))]);
    }

    /**
     * Build the statistics payload for a coupon.
     *
     * Financial figures (items sold, discount, sales) are computed on COMPLETED
     * orders only. Order counts are broken down across every status.
     *
     * @return array<string, mixed>
     */
    private function buildStatistics(Coupon $coupon): array
    {
        $countsByStatus = $coupon->orders()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $ordersByStatus = [];
        foreach (OrderStatusEnum::cases() as $case) {
            $ordersByStatus[$case->value] = (int) ($countsByStatus[$case->value] ?? 0);
        }

        return [
            'total_orders' => (int) array_sum($ordersByStatus),
            'orders_by_status' => $ordersByStatus,
            'orders_count' => $ordersByStatus[OrderStatusEnum::Completed->value],
            'items_count' => (int) $coupon->completedOrders()
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->sum('order_items.quantity'),
            'total_discount' => (float) $coupon->completedOrders()->sum('discount'),
            'total_sales' => (float) $coupon->completedOrders()->sum('total'),
        ];
    }

    /**
     * Normalize request payload (cast status to a boolean-ish int).
     *
     * @return array<string, mixed>
     */
    private function normalized(CouponRequest $request): array
    {
        $data = $request->validated();

        if (array_key_exists('status', $data)) {
            $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true) ? 1 : 0;
        }

        return $data;
    }
}
