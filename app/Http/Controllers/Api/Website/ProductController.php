<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\ProductResource;
use App\Models\Product;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of active products.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $search = $request->get('search');
        $limit = $request->get('limit');

        $query = Product::query()
            ->where('status', StatusEnum::ACTIVE)
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $products = $query->limit($limit)->get();
            return $this->responseData(ProductResource::collection($products));
        }

        $products = $query->paginate($perPage);
        return $this->responsePaginated([ProductResource::collection($products)]);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::where('status', StatusEnum::ACTIVE)
            ->findOrFail($id);

        return $this->responseData(new ProductResource($product));
    }
}
