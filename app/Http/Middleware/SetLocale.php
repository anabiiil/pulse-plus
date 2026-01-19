<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $locale = $request->header('Accept-Language', config('app.locale'));
        if (in_array($locale, $this->supportedLocales(), true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }

    protected function supportedLocales(): array
    {
        return ['en', 'ar'];
    }
}

