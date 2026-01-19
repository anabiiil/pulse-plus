<?php

namespace App\Filters;

use Closure;

class SortingFilter extends QueryFilter
{
    /**
     * Handle the query filter for sorting.
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

        return $builder->orderBy($sortBy, $sortDirection);
    }
}

