<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CreateCountryRequest;
use App\Http\Requests\Admin\Country\ImportRequest;
use App\Http\Resources\Dashboard\CountryResource;
use App\Imports\CountryImport;
use App\Models\Country;
use App\Models\Season;
use App\Support\Traits\Api\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    use ApiResponseTrait;

    public mixed $perPage, $sortBy, $orderBy, $search, $status;

    public function show($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return $this->responseError(msg: 'country not found');
        }
        return $this->responseData(new CountryResource($country));
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return $this->responseError(msg: 'country not found');
        }
        $country->delete();
        return $this->responseData([], msg: 'country deleted successfully');
    }


    public function list(Request $request)
    {
        $this->handleData($request);
        $query = Country::query();
        if ($this->search) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('iso3', 'like', "%$this->search%")
                ->orWhere('region', 'like', "%$this->search%")
                ->orWhere('subregion', 'like', "%$this->search%")
                ->orWhere('phone_code', 'like', "%$this->search%");
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
            'name' => "name",
            'region' => "region",
            'id' => 'id',
            'status' => 'status',
            'subregion' => 'subregion',
            'created_at' => 'created_at',
            'iso3' => 'iso3',
            'phone_code' => 'phone_code',
        ];
        $this->sortBy = $sortFieldMapping[$request->get('sortBy', 'id')];

        $this->perPage = $request->get('per_page', 50);
        $this->orderBy = $request->get('sortDesc', 'desc');
        $this->search = $request->get('search', null);
    }

    public function create(CreateCountryRequest $request)
    {
        $country = Country::create($request->validated());
        Cache::tags(['countries'])->flush();
        return $this->responseData([new CountryResource($country)], 201);
    }

    public function update(CreateCountryRequest $request, $id)
    {
        $data = $request->validated();
        $country = Country::find($id);

        $country->update($data);
        Cache::tags(['countries'])->flush();
        return $this->responseData([new CountryResource($country)], 200);
    }

    public function import(ImportRequest $request)
    {
        $data = $request->validated();
        Excel::import(new CountryImport(), $data['file']);
        Cache::tags(['countries'])->flush();
        return $this->responseData([], 200);
    }

}
