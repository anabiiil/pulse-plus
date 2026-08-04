<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\Dashboard\PaymentMethodResource;
use App\Models\File;
use App\Models\PaymentMethod;
use App\Support\Services\Image\ImageService;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentMethodController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected ImageService $imageService) {}

    /**
     * Display all payment methods (system ones first).
     */
    public function index(): JsonResponse
    {
        $methods = PaymentMethod::query()
            ->orderByDesc('is_system')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return $this->responseData(PaymentMethodResource::collection($methods));
    }

    /**
     * Store a new (custom) payment method.
     *
     * @throws Throwable
     */
    public function store(StorePaymentMethodRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $method = PaymentMethod::create([
                'name' => $request->validated('name'),
                'description' => $request->validated('description'),
                'is_active' => $this->boolInput($request->validated('is_active'), true),
                'requires_receipt' => $this->boolInput($request->validated('requires_receipt'), false),
                'is_system' => false,
            ]);

            if ($request->hasFile('image')) {
                $this->storeImage($request->file('image'), $method);
            }

            return $this->responseData(new PaymentMethodResource($method), 201);
        });
    }

    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        return $this->responseData(new PaymentMethodResource($paymentMethod));
    }

    /**
     * Update a payment method.
     *
     * System methods keep their locked name; only description, active state and
     * image can change for them. Custom methods can change everything.
     *
     * @throws Throwable
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): JsonResponse
    {
        return DB::transaction(function () use ($request, $paymentMethod) {
            $data = [];

            // Name can only change for non-system methods
            if (! $paymentMethod->is_system && $request->filled('name')) {
                $data['name'] = $request->validated('name');
            }

            if ($request->has('description')) {
                $data['description'] = $request->validated('description');
            }

            if ($request->has('is_active')) {
                $data['is_active'] = $this->boolInput($request->validated('is_active'), $paymentMethod->is_active);
            }

            if ($request->has('requires_receipt')) {
                $data['requires_receipt'] = $this->boolInput($request->validated('requires_receipt'), $paymentMethod->requires_receipt);
            }

            $paymentMethod->update($data);

            if ($request->hasFile('image')) {
                $paymentMethod->image()->first()?->delete();
                $this->storeImage($request->file('image'), $paymentMethod);
            }

            return $this->responseData(new PaymentMethodResource($paymentMethod->fresh()));
        });
    }

    /**
     * Delete a custom payment method. System methods cannot be deleted.
     *
     * @throws Throwable
     */
    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        if ($paymentMethod->is_system) {
            return $this->responseError([], 403, 'System payment methods cannot be deleted');
        }

        return DB::transaction(function () use ($paymentMethod) {
            $paymentMethod->image()->first()?->delete();
            $paymentMethod->delete();

            return $this->responseData([], msg: 'payment method deleted successfully');
        });
    }

    /**
     * Normalize a truthy/falsy request value to boolean.
     */
    private function boolInput(mixed $value, bool $default): bool
    {
        if ($value === null) {
            return $default;
        }

        return in_array($value, ['1', 1, 'true', true], true);
    }

    /**
     * Store an uploaded image and attach it to the payment method.
     */
    private function storeImage(mixed $file, PaymentMethod $method): void
    {
        $imageInfo = $this->imageService->storeImage($file, 'payment-methods', 'image', 'public');

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
            'file_id' => $method->id,
            'file_type' => PaymentMethod::class,
        ]);
    }
}
