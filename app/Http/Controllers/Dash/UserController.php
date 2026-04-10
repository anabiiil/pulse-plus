<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Resources\Dashboard\UserResource;
use App\Models\Item;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use App\Support\Enums\Item\ItemStatusEnum;
use App\Support\Enums\User\UserSubscriptionStatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        $sortBy = self::SORT_FIELD_MAPPING[$request->get('sortBy', 'id')] ?? 'id';
        $sortDesc = $request->get('sortDesc', 'desc');
        $search = $request->get('search');

        $perPage = $perPage === -1 ? (User::count() ?: self::DEFAULT_PER_PAGE) : $perPage;

        $users = User::query()
            ->with('country', 'item', 'latestSubscription.subscription')
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
            $subscriptionId = $data['subscription_id'] ?? null;
            unset($data['subscription_id']);

            $data['password'] = Hash::make($data['password']);
            $data['hash_url'] = Str::uuid();

            // Convert status to boolean properly
            if (isset($data['status'])) {
                $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
            }

            $user = User::create($data);

            if (! empty($data['item_id'])) {
                Item::where('id', $data['item_id'])->update(['status' => ItemStatusEnum::Used]);
            }

            if ($subscriptionId) {
                $this->assignSubscription($user, (int) $subscriptionId);
            }

            $user->load('latestSubscription.subscription');

            return $this->responseData(new UserResource($user), 201);
        });
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        $user->load('country', 'medicalInfo', 'diseases', 'item', 'latestSubscription.subscription');

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
            $oldItemId = $user->item_id;
            $newItemId = $data['item_id'] ?? null;
            $subscriptionId = $data['subscription_id'] ?? null;
            unset($data['subscription_id']);

            // Only update password if provided
            if (! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Convert status to boolean properly
            if (isset($data['status'])) {
                $data['status'] = in_array($data['status'], ['1', 1, 'true', true], true);
            }

            $user->update($data);

            // Sync item statuses when assignment changes
            if ($oldItemId !== $newItemId) {
                if ($oldItemId) {
                    Item::where('id', $oldItemId)->update(['status' => ItemStatusEnum::Active]);
                }
                if ($newItemId) {
                    Item::where('id', $newItemId)->update(['status' => ItemStatusEnum::Used]);
                }
            }

            if ($subscriptionId) {
                $user->load('latestSubscription');
                $currentSubscriptionId = $user->latestSubscription?->subscription_id;

                if ((int) $subscriptionId !== (int) $currentSubscriptionId) {
                    $this->assignSubscription($user, (int) $subscriptionId);
                }
            }

            $user->load('latestSubscription.subscription');

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
            if ($user->item_id) {
                Item::where('id', $user->item_id)->update(['status' => ItemStatusEnum::Active]);
            }

            $user->delete();

            return $this->responseData([], msg: 'user deleted successfully');
        });
    }

    /**
     * Create a new user_subscription record based on subscription months,
     * ending any previously active subscriptions first.
     */
    private function assignSubscription(User $user, int $subscriptionId): void
    {
        $subscription = Subscription::find($subscriptionId);

        if (! $subscription) {
            return;
        }

        // End all currently active subscriptions for this user
        UserSubscription::query()
            ->where('user_id', $user->id)
            ->where('status', UserSubscriptionStatusEnum::Active)
            ->update(['status' => UserSubscriptionStatusEnum::Ended->value]);

        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addMonths($subscription->months);

        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $subscriptionId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => UserSubscriptionStatusEnum::Active->value,
        ]);
    }
}
