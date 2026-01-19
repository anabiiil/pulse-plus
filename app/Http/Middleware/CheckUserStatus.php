<?php

namespace App\Http\Middleware;

use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('user-api')->user())
            return $this->responseError(code: 401, msg: __('lang.alerts.unauthenticated'));
        if (auth('user-api')->user()->status?->value != StatusEnum::ACTIVE?->value)
            return $this->responseError(code: 403, msg: __('lang.alerts.not_authorized'));

        return $next($request);
    }
}
