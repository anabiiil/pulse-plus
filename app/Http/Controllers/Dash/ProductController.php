<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Resources\Dashboard\ProductResource;
use App\Models\File;
use App\Models\Product;
use App\Support\Services\Image\ImageService;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'name' => 'name',
        'id' => 'id',
        'status' => 'status',
        'price' => 'price',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    public function __construct(protected ImageService $imageService) {}

    /**
     * Display a listing of products with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Product::count() : $perPage;

        $products = Product::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([ProductResource::collection($products)]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\JsonResponse
    {

        return DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $this->extracted($request, $product);
            }

            return $this->responseData(new ProductResource($product), 201);
        });
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new ProductResource($product));
    }

    /**
     * Update the specified product in storage.
     *
     * @throws Throwable
     */
    public function update(CreateProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {

        return DB::transaction(function () use ($request, $product) {
            $data = $request->validated();
            $data['status'] = $data['status'] == 'true' ?? false;

            $product->update($data);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldImage = $product->image()->first();
                $oldImage?->delete();

                $this->extracted($request, $product);
            }

            return $this->responseData(new ProductResource($product));
        });
    }

    /**
     * Remove the specified product from storage.
     *
     * @throws Throwable
     */
    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($product) {
            // Delete associated image if exists
            $image = $product->image()->first();
            if ($image) {
                $image->delete();
            }

            $product->delete();

            return $this->responseData([], msg: 'product deleted successfully');
        });
    }

    public function extracted(CreateProductRequest $request, Product $product): void
    {
        $imageInfo = $this->imageService->storeImage(
            $request->file('image'),
            'products',
            'image',
            'public'
        );

        File::create([
            'file_name' => $imageInfo['file_name'],
            'original_name' => $imageInfo['original_name'],
            'mime_type' => $imageInfo['mime_type'],
            'collection_name' => 'image',
            'type' => 'image',
            'storage' => 'public',
            'url' => $imageInfo['url'],
            'path' => $imageInfo['path'],
            'size' => $imageInfo['size'],
            'file_id' => $product->id,
            'file_type' => Product::class,
        ]);
    }
}
