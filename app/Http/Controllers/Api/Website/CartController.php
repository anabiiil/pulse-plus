<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get the current user's cart.
     */
    public function index(): JsonResponse
    {
        return $this->responseData($this->cartPayload($this->userCart()));
    }

    /**
     * Add a product to the cart (increments quantity if already present).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:999',
        ]);

        $product = Product::where('status', StatusEnum::ACTIVE)->find($validated['product_id']);
        if (! $product) {
            return $this->responseError([], 404, 'Product not found');
        }

        $cart = $this->userCart();
        $quantity = $validated['quantity'] ?? 1;

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->save();

        return $this->responseData($this->cartPayload($cart->fresh()), 201);
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeItem($cartItem);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return $this->responseData($this->cartPayload($cartItem->cart->fresh()));
    }

    /**
     * Remove a cart item.
     */
    public function destroy(CartItem $cartItem): JsonResponse
    {
        $this->authorizeItem($cartItem);
        $cart = $cartItem->cart;
        $cartItem->delete();

        return $this->responseData($this->cartPayload($cart->fresh()));
    }

    /**
     * Empty the cart.
     */
    public function clear(): JsonResponse
    {
        $cart = $this->userCart();
        $cart->items()->delete();

        return $this->responseData($this->cartPayload($cart->fresh()));
    }

    /**
     * Get or create the authenticated user's cart.
     */
    private function userCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth('web')->id()]);
    }

    /**
     * Ensure the cart item belongs to the current user.
     */
    private function authorizeItem(CartItem $cartItem): void
    {
        abort_unless($cartItem->cart->user_id === auth('web')->id(), 403, 'Forbidden');
    }

    /**
     * Build the cart response payload with live product data and totals.
     *
     * @return array<string, mixed>
     */
    private function cartPayload(Cart $cart): array
    {
        $cart->load(['items.product.image']);

        $items = $cart->items
            ->filter(fn (CartItem $item) => $item->product !== null)
            ->map(function (CartItem $item) {
                $price = (float) $item->product->price;

                return [
                    'id' => (int) $item->id,
                    'product_id' => (int) $item->product_id,
                    'name' => $item->product->name,
                    'price' => $price,
                    'image_url' => $item->product->image?->file_url,
                    'quantity' => (int) $item->quantity,
                    'line_total' => round($price * $item->quantity, 2),
                ];
            })
            ->values();

        return [
            'id' => (int) $cart->id,
            'items' => $items,
            'count' => (int) $items->sum('quantity'),
            'subtotal' => round($items->sum('line_total'), 2),
        ];
    }
}
