<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use App\Models\User;
use App\Support\Enums\Main\OrderStatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponseTrait;

    /**
     * System-wide statistics for the dashboard home page.
     *
     * Revenue-related figures are computed on COMPLETED orders only.
     */
    public function statistics(): JsonResponse
    {
        $ordersByStatus = [];
        foreach (OrderStatusEnum::cases() as $case) {
            $ordersByStatus[$case->value] = Order::where('status', $case->value)->count();
        }

        $completed = Order::where('status', OrderStatusEnum::Completed->value);

        return $this->responseData([
            'users' => User::count(),
            'products' => Product::count(),
            'services' => Service::count(),
            'sliders' => Slider::count(),
            'payment_methods' => PaymentMethod::count(),
            'coupons' => Coupon::count(),
            'orders' => [
                'total' => Order::count(),
                'by_status' => $ordersByStatus,
            ],
            'revenue' => [
                'completed_orders' => (clone $completed)->count(),
                'total_sales' => (float) (clone $completed)->sum('total'),
                'total_discount' => (float) (clone $completed)->sum('discount'),
            ],
        ]);
    }
}
