<?php

namespace App\Filters;

use Auth;
use Closure;

class VendorDefaultFilter extends QueryFilter
{
    /**
     * Handle the query filter for vendor agency and sorting.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(mixed $request, Closure $next): mixed
    {
        $builder = $next($request);

        $sortDirection = request()->input('sort_direction', 'desc');

        $sortBy = request()->input('sort_column', 'id');

        return $builder
            ->when(request()->filled('is_active'), fn($q) => $q->where('is_active', request()->boolean('is_active')))
//            ->where('agency_id', Auth::guard('vendor-api')->user()?->agency_id)
            ->orderBy($sortBy, $sortDirection);

    }
}

