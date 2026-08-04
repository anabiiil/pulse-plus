<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\CheckoutRequest;
use App\Http\Resources\Website\OrderResource;
use App\Models\Cart;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Support\Enums\Main\OrderStatusEnum;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CheckoutController extends Controller
{
    use ApiResponseTrait;

    /**
     * Place an order from the current user's cart.
     *
     * Totals are recomputed server-side from live product/governorate prices and
     * then frozen as snapshots on the order and its items.
     *
     * @throws Throwable
     */
    public function store(CheckoutRequest $request): JsonResponse
    {
        $userId = auth('web')->id();

        $cart = Cart::with('items.product')->firstOrCreate(['user_id' => $userId]);
        $items = $cart->items->filter(fn ($item) => $item->product !== null);

        if ($items->isEmpty()) {
            return $this->responseError([], 422, 'Your cart is empty');
        }

        $governorate = Governorate::where('status', StatusEnum::ACTIVE)->find($request->validated('governorate_id'));
        if (! $governorate) {
            return $this->responseError([], 422, 'Invalid governorate');
        }

        $paymentMethod = PaymentMethod::where('is_active', true)->find($request->validated('payment_method_id'));
        if (! $paymentMethod) {
            return $this->responseError([], 422, 'Invalid payment method');
        }

        // A receipt is required when the chosen payment method demands one
        if ($paymentMethod->requires_receipt && ! $request->hasFile('receipt')) {
            return $this->returnValidationError(
                validator(['receipt' => null], ['receipt' => 'required'])
            );
        }

        $receiptUrl = null;
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $receiptUrl = Storage::disk('public')->url($path);
        }

        $order = DB::transaction(function () use ($cart, $items, $governorate, $paymentMethod, $receiptUrl, $request, $userId) {
            $subtotal = 0;
            $lines = [];

            foreach ($items as $item) {
                $price = (float) $item->product->price;
                $lineTotal = round($price * $item->quantity, 2);
                $subtotal += $lineTotal;

                $lines[] = [
                    'product_id' => $item->product_id,
                    'product_name' => (string) $item->product->name,
                    'product_price' => $price,
                    'quantity' => (int) $item->quantity,
                    'line_total' => $lineTotal,
                ];
            }

            $shippingPrice = (float) $governorate->delivery_price;
            $subtotal = round($subtotal, 2);
            $total = round($subtotal + $shippingPrice, 2);

            $order = Order::create([
                'order_number' => 'ORD-'.now()->format('ymd').'-'.Str::upper(Str::random(5)),
                'user_id' => $userId,
                'customer_name' => $request->validated('customer_name'),
                'customer_phone' => $request->validated('customer_phone'),
                'governorate_id' => $governorate->id,
                'governorate_name' => (string) $governorate->name,
                'address' => $request->validated('address'),
                'shipping_method' => 'governorate_delivery',
                'shipping_price' => $shippingPrice,
                'payment_method_id' => $paymentMethod->id,
                'payment_method_code' => $paymentMethod->code,
                'payment_method_name' => $paymentMethod->getTranslations('name'),
                'payment_method_image' => $paymentMethod->image?->file_url,
                'receipt_url' => $receiptUrl,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => OrderStatusEnum::Pending,
                'notes' => $request->validated('notes'),
            ]);

            $order->items()->createMany($lines);

            // Empty the cart after a successful order
            $cart->items()->delete();

            return $order;
        });

        return $this->responseData(new OrderResource($order->load('items')), 201, 'Order placed successfully');
    }
}
