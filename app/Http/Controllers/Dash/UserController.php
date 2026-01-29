<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\User;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    use ApiResponseTrait;

    private const array SORT_FIELD_MAPPING = [
        'name' => 'name',
        'email' => 'email',
        'id' => 'id',
        'status' => 'status',
    ];

    private const int DEFAULT_PER_PAGE = 50;

    /**
     * Display a listing of users with filtering and pagination.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? User::count() : $perPage;

        $users = User::query()
            ->with('country')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDesc)
            ->paginate($perPage);

        return $this->responsePaginated([UserResource::collection($users)]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(CreateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['hash_url'] = Str::uuid();

            // Convert status to boolean properly
            if (isset($data['status'])) {
                $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
            }

            $user = User::create($data);

            return $this->responseData(new UserResource($user), 201);
        });
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        $user->load('country', 'medicalInfo', 'diseases');
        return $this->responseData(new UserResource($user));
    }

    /**
     * Update the specified user in storage.
     *
     * @throws Throwable
     */
    public function update(CreateUserRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request, $user) {
            $data = $request->validated();

            // Only update password if provided
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Convert status to boolean properly
            if (isset($data['status'])) {
                $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
            }

            $user->update($data);

            return $this->responseData(new UserResource($user));
        });
    }

    /**
     * Remove the specified user from storage.
     *
     * @throws Throwable
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($user) {
            $user->delete();
            return $this->responseData([], msg: 'user deleted successfully');
        });
    }
}
