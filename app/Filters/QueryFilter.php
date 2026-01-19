<?php

namespace App\Filters;

use Closure;

abstract class QueryFilter
{
    /**
     * Handle the query filter.
     *
     * @param mixed $request
     * @param Closure $next
     * @return mixed
     */
    abstract public function handle(mixed $request, Closure $next): mixed;
}
