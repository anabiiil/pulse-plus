<?php

namespace App\Filters;

use Closure;

class FilterIsActive extends QueryFilter
{
    /**
     * Handle the query filter for is_active status.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(mixed $request, Closure $next): mixed
    {
        return $next($request)->when(request()->filled('is_active'), fn($q) => $q->where('is_active', request()->boolean('is_active')));
    }
}

