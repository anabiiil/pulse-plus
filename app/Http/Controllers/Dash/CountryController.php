<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CreateCountryRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Models\Country;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'name' => 'name',
        'id' => 'id',
        'status' => 'status',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of countries with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? Country::count() : $perPage;

        $countries = Country::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([CountryResource::collection($countries)]);
    }

    /**
     * Store a newly created country in storage.
     */
    public function store(CreateCountryRequest $request): \Illuminate\Http\JsonResponse
    {
        $country = Country::create($request->validated());

        return $this->responseData(new CountryResource($country), 201);
    }

    /**
     * Display the specified country.
     */
    public function show(Country $country): \Illuminate\Http\JsonResponse
    {
        return $this->responseData(new CountryResource($country));
    }

    /**
     * Update the specified country in storage.
     */
    public function update(CreateCountryRequest $request, Country $country): \Illuminate\Http\JsonResponse
    {
        $country->update($request->validated());

        return $this->responseData(new CountryResource($country));
    }

    /**
     * Remove the specified country from storage.
     */
    public function destroy(Country $country): \Illuminate\Http\JsonResponse
    {
        $country->delete();

        return $this->responseData([], msg: 'country deleted successfully');
    }
}
