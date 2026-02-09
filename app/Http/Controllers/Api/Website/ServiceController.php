<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\ServiceResource;
use App\Models\Service;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of active services.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $search = $request->get('search');
        $limit = $request->get('limit');

        $query = Service::query()
            ->where('status', StatusEnum::ACTIVE)
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $services = $query->limit($limit)->get();
            return $this->responseData(ServiceResource::collection($services));
        }

        $services = $query->paginate($perPage);
        return $this->responsePaginated([ServiceResource::collection($services)]);
    }

    /**
     * Display the specified service.
     */
    public function show($id)
    {
        $service = Service::where('status', StatusEnum::ACTIVE)
            ->findOrFail($id);

        return $this->responseData(new ServiceResource($service));
    }
}
