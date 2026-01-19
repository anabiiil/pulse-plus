<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Filters\FilterByAgencyId;
use App\Filters\FilterByName;
use App\Filters\FilterIsActive;
use App\Filters\SortingFilter;
use App\Filters\VendorDefaultFilter;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageIndexRequest;
use App\Http\Requests\Vendor\NutritionPlan\NutritionPlanRequest;
use App\Http\Requests\Vendor\NutritionPlan\UpdateNutritionPlanRequest;
use App\Http\Resources\PlanNutritionResource;
use App\Models\PlanNutrition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class NutritionPlanController extends Controller
{

    public function index(PageIndexRequest $request): JsonResponse
    {
        $query = app(Pipeline::class)
            ->send(PlanNutrition::query()->byAgencyId())
            ->through([
                VendorDefaultFilter::class,
                FilterByName::class,
            ])
            ->thenReturn();


        return ApiResponse::responseIndex(
            $query,
            PlanNutritionResource::class,
            $request->input('per_page', 15),
        );
    }

    public function store(NutritionPlanRequest $request): JsonResponse
    {

        $plan = PlanNutrition::create($request->validated())->syncImage($request->file('image'));

        return ApiResponse::success(
            $plan->toResource(PlanNutritionResource::class),
            message: 'Nutrition plan created successfully',
            status: 201
        );
    }

    public function show(int $id, Request $request): JsonResponse
    {
        $plan = PlanNutrition::byAgencyId()->findOrFail($id);

        return ApiResponse::success(
            $plan->toResource(PlanNutritionResource::class),
            message: 'Nutrition plan retrieved successfully'
        );
    }

    public function update(UpdateNutritionPlanRequest $request, int $id): JsonResponse
    {

        $plan = PlanNutrition::byAgencyId()->findOrFail($id);

        $plan->update($request->validated());
        $plan->syncImage($request->file('image'));

        return ApiResponse::success(
            $plan->toResource(PlanNutritionResource::class),
            message: 'Nutrition plan updated successfully'
        );
    }

    public function destroy(int $id): JsonResponse
    {

        PlanNutrition::byAgencyId()->findOrFail($id)?->delete();

        return ApiResponse::success(
            null,
            message: 'Nutrition plan deleted successfully'
        );
    }

    public function toggleActive(int $id): JsonResponse
    {
        $vendor = Auth::guard('vendor-api')->user();

        $plan = PlanNutrition::byAgencyId()->findOrFail($id);


        $plan->update(['is_active' => !$plan->is_active]);

        return ApiResponse::success($plan->toResource(PlanNutritionResource::class),
            message: 'Nutrition plan status updated successfully'
        );
    }

    /**
     * Sync meals with the nutrition plan
     * Expects: { "meals": [{"meal_id": 1, "meal_type": "breakfast", "sort_order": 1}, ...] }
     */
    public function syncMeals(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'meals' => 'required|array',
            'meals.*.meal_id' => 'required|integer|exists:meals,id',
            'meals.*.meal_type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'meals.*.sort_order' => 'nullable|integer|min:0',
        ]);

        $plan = PlanNutrition::byAgencyId()->findOrFail($id);
        $plan->syncMeals($request->input('meals'));

        return ApiResponse::success(
            $plan->load('meals')->toResource(PlanNutritionResource::class),
            message: 'Meals synced successfully'
        );
    }

    /**
     * Attach a single meal to the nutrition plan
     * Expects: { "meal_id": 1, "meal_type": "breakfast", "sort_order": 1 }
     */
    public function attachMeal(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'meal_id' => 'required|integer|exists:meals,id',
            'meal_type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $plan = PlanNutrition::byAgencyId()->findOrFail($id);
        $plan->attachMeal(
            $request->input('meal_id'),
            $request->input('meal_type', 'breakfast'),
            $request->input('sort_order', 0)
        );

        return ApiResponse::success(
            $plan->load('meals')->toResource(PlanNutritionResource::class),
            message: 'Meal attached successfully'
        );
    }

    /**
     * Detach a meal from the nutrition plan
     */
    public function detachMeal(int $id, int $mealId): JsonResponse
    {
        $plan = PlanNutrition::byAgencyId()->findOrFail($id);
        $plan->detachMeal($mealId);

        return ApiResponse::success(
            $plan->load('meals')->toResource(PlanNutritionResource::class),
            message: 'Meal detached successfully'
        );
    }

    /**
     * Update meal pivot data (meal_type, sort_order)
     * Expects: { "meal_type": "lunch", "sort_order": 2 }
     */
    public function updateMealPivot(Request $request, int $id, int $mealId): JsonResponse
    {
        $request->validate([
            'meal_type' => 'nullable|string|in:breakfast,lunch,dinner,snack',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $plan = PlanNutrition::byAgencyId()->findOrFail($id);
        $plan->updateMealPivot($mealId, $request->only(['meal_type', 'sort_order']));

        return ApiResponse::success(
            $plan->load('meals')->toResource(PlanNutritionResource::class),
            message: 'Meal updated successfully'
        );
    }
}


