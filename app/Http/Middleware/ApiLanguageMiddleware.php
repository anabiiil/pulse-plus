<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class ApiLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the language from the request header
        $language = $request->header('Accept-Language');
        // Set the application locale if a supported language is detected
        if ($language && LaravelLocalization::checkLocaleInSupportedLocales($language)) {
            LaravelLocalization::setLocale($language);
        }

        return $next($request);
    }
}
