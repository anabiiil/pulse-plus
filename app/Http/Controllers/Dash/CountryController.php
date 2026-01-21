<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CreateCountryRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Models\Country;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    use ApiResponseTrait;

    public mixed $perPage;

    public mixed $sortBy;

    public mixed $orderBy;

    public mixed $search;

    public mixed $status;

    public function show(Country $country): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new CountryResource($country));
    }

    public function destroy(Country $country): \Illuminate\Http\JsonResponse
    {
        $country->delete();

        return $this->responseData([], msg: 'country deleted successfully');
    }

    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->handleData($request);
        $query = Country::query();
        if ($this->search) {
            $query->where('name', 'like', "%$this->search%");
        }
        $query->orderBy(DB::raw($this->sortBy), $this->orderBy);

        if ($this->perPage == -1) {
            $this->perPage = Country::count();
        }

        return $this->responsePaginated([CountryResource::collection($query->paginate($this->perPage))]);
    }

    public function handleData($request)
    {
        $sortFieldMapping = [
            'name' => 'name',
            'id' => 'id',
            'status' => 'status',

        ];
        $this->sortBy = $sortFieldMapping[$request->get('sortBy', 'id')];

        $this->perPage = $request->get('per_page', 50);
        $this->orderBy = $request->get('sortDesc', 'desc');
        $this->search = $request->get('search', null);
    }

    public function create(CreateCountryRequest $request): \Illuminate\Http\JsonResponse
    {
        $country = Country::create($request->validated());

        return $this->responseData([new CountryResource($country)], 201);
    }

    public function update(CreateCountryRequest $request,Country $country)
    {
        $data = $request->validated();
        $country->update($data);

        return $this->responseData([new CountryResource($country)], 200);
    }
}
