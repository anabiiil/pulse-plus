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
     * Get or create the cart for the current visitor.
     *
     * Logged-in users get a cart keyed by their id; guests get one keyed by
     * their session id so they can shop without an account.
     */
    private function userCart(): Cart
    {
        $userId = auth('web')->id();

        if ($userId) {
            return Cart::firstOrCreate(['user_id' => $userId]);
        }

        return Cart::firstOrCreate([
            'session_id' => session()->getId(),
            'user_id' => null,
        ]);
    }

    /**
     * Ensure the cart item belongs to the current visitor (user or guest session).
     */
    private function authorizeItem(CartItem $cartItem): void
    {
        $cart = $cartItem->cart;
        $userId = auth('web')->id();

        $ownsByUser = $userId && (int) $cart->user_id === (int) $userId;
        $ownsBySession = $cart->session_id && $cart->session_id === session()->getId();

        abort_unless($ownsByUser || $ownsBySession, 403, 'Forbidden');
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
