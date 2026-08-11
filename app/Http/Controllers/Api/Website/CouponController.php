<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ApiResponseTrait;

    /**
     * Validate a coupon code against the current cart and return a discount preview.
     */
    public function validateCode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100',
        ]);

        $coupon = Coupon::where('code', $validated['code'])->first();

        if (! $coupon || ! $coupon->isRedeemable()) {
            return $this->responseError([], 422, __('messages.coupon_invalid'));
        }

        $userId = auth('web')->id();

        $cart = $userId
            ? Cart::with('items.product')->firstOrCreate(['user_id' => $userId])
            : Cart::with('items.product')->firstOrCreate(['session_id' => session()->getId(), 'user_id' => null]);

        $subtotal = $cart->items
            ->filter(fn ($item) => $item->product !== null)
            ->sum(fn ($item) => round((float) $item->product->price * $item->quantity, 2));

        if ($subtotal <= 0) {
            return $this->responseError([], 422, __('messages.cart_empty'));
        }

        $discount = $coupon->discountFor((float) $subtotal);

        return $this->responseData([
            'code' => $coupon->code,
            'type' => $coupon->type->value,
            'value' => (float) $coupon->value,
            'subtotal' => (float) $subtotal,
            'discount' => $discount,
        ], msg: __('messages.coupon_applied'));
    }
}
