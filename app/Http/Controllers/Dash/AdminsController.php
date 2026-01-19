<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\CreateAdminRequest;
use App\Http\Requests\Admin\Admins\UpdateAdminRequest;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Dashboard\AdminResource;
use App\Models\Admin;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    use ApiResponseTrait;

    public mixed $perPage, $sortBy, $orderBy, $search;


    public function index()
    {

        return view('dash.pages.admins.index');
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->responseError(msg: 'Employee not found');
        }
        return $this->responseData(new AdminResource($admin));
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->responseError(msg: 'Employee not found');
        }
        $admin->delete();
        return $this->responseData([], msg: 'Employee deleted successfully');
    }


    public function list(Request $request)
    {
        $query = Admin::query();
        $this->handleData($request);
        if ($this->search) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('email', 'like', "%$this->search%");
        }

        if ($this->sortBy) {
            $query->orderBy($this->sortBy, $this->orderBy);
        }else{
            $query->orderBy('id', 'desc');
        }
        if ($this->perPage == -1) {
            $this->perPage = Admin::count();
        }
        return $this->responseData($query->paginate($this->perPage));
    }

    public function handleData($request)
    {
        $this->perPage = $request->get('per_page', 50);
        $this->sortBy = $request->get('sortBy');
        $this->orderBy = $request->get('sortDesc');
        $this->search = $request->get('search', '');
    }

    public function create(CreateAdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        return $this->responseData([new AdminResource($admin)], 201);
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $data = $request->validated();
        $admin = Admin::find($id);
        if($admin['password'] || $admin['password'] == null){
            unset($data['password']);
        }
        $admin->update($data);
        return $this->responseData([new AdminResource($admin)], 200);
    }

}
