<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Filters\FilterByName;
use App\Filters\VendorDefaultFilter;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageIndexRequest;
use App\Http\Requests\Vendor\Meal\MealRequest;
use App\Http\Requests\Vendor\Meal\UpdateMealRequest;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    public function index(PageIndexRequest $request): JsonResponse
    {
        $query = app(Pipeline::class)
            ->send(Meal::query()->byAgencyId())
            ->through([
                VendorDefaultFilter::class,
                FilterByName::class,
            ])
            ->thenReturn();

        return ApiResponse::responseIndex(
            $query,
            MealResource::class,
            $request->input('per_page', 15),
        );
    }

    public function store(MealRequest $request): JsonResponse
    {
        $meal = Meal::create($request->validated())->syncImage($request->file('image'));

        return ApiResponse::success(
            $meal->toResource(MealResource::class),
            message: 'Meal created successfully',
            status: 201
        );
    }

    public function show(int $id): JsonResponse
    {
        $meal = Meal::byAgencyId()->findOrFail($id);

        return ApiResponse::success(
            $meal->toResource(MealResource::class),
            message: 'Meal retrieved successfully'
        );
    }

    public function update(UpdateMealRequest $request, int $id): JsonResponse
    {
        $meal = Meal::byAgencyId()->findOrFail($id);

        $meal->update($request->validated());
        $meal->syncImage($request->file('image'));

        return ApiResponse::success(
            $meal->toResource(MealResource::class),
            message: 'Meal updated successfully'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        Meal::byAgencyId()->findOrFail($id)?->delete();

        return ApiResponse::success(
            null,
            message: 'Meal deleted successfully'
        );
    }

    public function toggleActive(int $id): JsonResponse
    {
        $meal = Meal::byAgencyId()->findOrFail($id);

        $meal->update(['is_active' => !$meal->is_active]);

        return ApiResponse::success(
            $meal->toResource(MealResource::class),
            message: 'Meal status updated successfully'
        );
    }
}

