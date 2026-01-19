<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Facades\ResponseCache;

class VaryCacheByLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Configure ResponseCache to vary by 'Accept-Language' header
        ResponseCache::addVary('Accept-Language');

        return $next($request);
    }
}
