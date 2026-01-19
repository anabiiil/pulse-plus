<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Facades\Auth;

class FilterByAgencyId extends QueryFilter
{
    /**
     * Handle the query filter for agency_id.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(mixed $request, Closure $next): mixed
    {
        return $next($request)->where('agency_id', Auth::guard('vendor-api')->user()?->agency_id);
    }
}

