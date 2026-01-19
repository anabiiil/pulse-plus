<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Enums\VendorType;
use App\Filters\FilterByName;
use App\Filters\FilterIsActive;
use App\Filters\VendorDefaultFilter;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageIndexRequest;
use App\Http\Requests\Vendor\Employee\EmployeeRequest;
use App\Http\Requests\Vendor\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees
     */
    public function index(PageIndexRequest $request): JsonResponse
    {
        $query = app(Pipeline::class)
            ->send(Vendor::query()->employees()->byAgencyId())
            ->through([
                VendorDefaultFilter::class,
                FilterByName::class,
            ])
            ->thenReturn();

        return ApiResponse::responseIndex(
            $query,
            EmployeeResource::class,
            $request->input('per_page', 15),
        );
    }

    /**
     * Store a newly created employee
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        $vendor = Auth::guard('vendor-api')->user();

        $data = $request->validated();
        $data['type'] = VendorType::EMPLOYEE;
        $data['agency_id'] = $vendor?->agency_id;

        $employee = Vendor::create($data);

        return ApiResponse::success(
            $employee->toResource(EmployeeResource::class),
            message: 'Employee created successfully',
            status: 201
        );
    }

    /**
     * Display the specified employee
     */
    public function show(int $id): JsonResponse
    {
        $employee = Vendor::employees()
            ->byAgencyId()
            ->findOrFail($id);

        return ApiResponse::success(
            $employee->toResource(EmployeeResource::class),
            message: 'Employee retrieved successfully'
        );
    }

    /**
     * Update the specified employee
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $employee = Vendor::employees()
            ->byAgencyId()
            ->findOrFail($id);

        $data = $request->validated();

        // Only update password if provided
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $employee->update($data);

        return ApiResponse::success(
            $employee->toResource(EmployeeResource::class),
            message: 'Employee updated successfully'
        );
    }

    /**
     * Remove the specified employee
     */
    public function destroy(int $id): JsonResponse
    {
        $employee = Vendor::employees()
            ->byAgencyId()
            ->findOrFail($id);

        $employee->delete();

        return ApiResponse::success(
            null,
            message: 'Employee deleted successfully'
        );
    }

    /**
     * Toggle employee active status
     */
    public function toggleActive(int $id): JsonResponse
    {
        $employee = Vendor::employees()
            ->byAgencyId()
            ->findOrFail($id);

        $employee->update(['status' => !$employee->status]);

        return ApiResponse::success(
            $employee->toResource(EmployeeResource::class),
            message: 'Employee status updated successfully'
        );
    }
}

