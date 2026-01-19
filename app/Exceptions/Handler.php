<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        // Check if it's a ValidationException and wants JSON response
        if ($e instanceof ValidationException && $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        return parent::render($request, $e);
    }
}
