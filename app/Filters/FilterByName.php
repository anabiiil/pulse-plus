<?php

namespace App\Filters;

use Closure;

class FilterByName extends QueryFilter
{
    /**
     * Handle the query filter for name/title search.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(mixed $request, Closure $next): mixed
    {
        $builder = $next($request);

        $search = request('search');

        return $builder->when(request()->filled('search'), fn($q) => $q->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('title', 'LIKE', "%{$search}%");
        }));
    }
}

