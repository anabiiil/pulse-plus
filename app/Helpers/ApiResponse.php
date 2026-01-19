<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Success response
     *
     * @param mixed|null $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public static function success(mixed $data = null, string $message = 'Success', int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $data,
            ],
            $status,
        );
    }

    public static function resolveEmptyToNull($value)
    {
        if (is_array($value)) {
            return collect($value)->map(fn($v) => resolveEmptyToNull($v))->toArray();
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed === '' || strtolower($trimmed) === 'null') {
                return null;
            }
        }

        if ($value === []) {
            return null;
        }

        return $value;
    }


    /**
     * Error response
     *
     * @param string $message
     * @param mixed|null $errors
     * @param int $status
     * @return JsonResponse
     */
    public static function error(string $message = 'Error', mixed $errors = null, int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $status);
    }

    /**
     * Validation error response
     *
     * @param array $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function validationError(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return self::error($message, $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Not found response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Unauthorized response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Forbidden response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, null, Response::HTTP_FORBIDDEN);
    }

    /**
     * Server error response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function serverError(string $message = 'Internal server error'): JsonResponse
    {
        return self::error($message, null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * Paginate response with comprehensive metadata
     *
     * @param mixed $items The paginator object
     * @param string $resourceClass Resource class for transformation
     * @param int $perPage
     * @param string $message Response message
     * @return JsonResponse
     */
    public static function paginate(mixed $items, string $resourceClass, int $perPage, string $message = 'Data retrieved successfully'): JsonResponse
    {
        $items = $items->paginate($perPage);
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $items->items()?->toResource($resourceClass),
                'pagination' => [
                    'total' => $items->total(),
                    'per_page' => $items->perPage(),
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'from' => $items->firstItem(),
                    'to' => $items->lastItem(),
                    'has_more_pages' => $items->currentPage() < $items->lastPage(),
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * Simple paginate response (previous/next navigation only)
     *
     * @param mixed $items The paginator object
     * @param string $resourceClass Resource class for transformation
     * @param int $perPage
     * @param string $message Response message
     * @return JsonResponse
     */
    public static function simplePaginate(mixed $items, string $resourceClass, int $perPage, string $message = 'Data retrieved successfully'): JsonResponse
    {
        $items = $items->simplePaginate($perPage);
        $currentPage = $items->currentPage();
        $hasMorePages = $items->hasMorePages();
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $items->items()?->toResource($resourceClass),
                'pagination' => [
                    'per_page' => $items->perPage(),
                    'current_page' => $currentPage,
                    'has_more_pages' => $hasMorePages,
                    'next_page' => $hasMorePages ? $currentPage + 1 : null,
                    'prev_page' => $currentPage > 1 ? $currentPage - 1 : null,
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * Cursor-based paginate response (for large datasets)
     *
     * @param mixed $items
     * @param string $resourceClass
     * @param int $perPage
     * @param string $message Response message
     * @return JsonResponse
     */
    public static function cursorPaginate(mixed $items, string $resourceClass, int $perPage, string $message = 'Data retrieved successfully'): JsonResponse
    {
        $items = $items->cursorPaginate($perPage);
        $pagination = [
            'per_page' => $items->perPage(),
            'next_cursor' => $items->nextCursor()?->encode(),
            'prev_cursor' => $items->previousCursor()?->encode(),
            'has_more_pages' => $items->hasMorePages(),
        ];

        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $items->items()?->toResource($resourceClass),
                'pagination' => $pagination,
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * Cursor-based paginate response (for large datasets)
     *
     * @param mixed $items
     * @param string $resourceClass
     * @param int $perPage
     * @param string $message Response message
     * @return JsonResponse
     */
    public static function responseIndex(mixed $items, string $resourceClass, int $perPage, string $message = 'Data retrieved successfully'): JsonResponse
    {
        $defaultMethod = config('pagination.method', 'paginate');
        return match ($perPage) {
            -1 => self::success($items->toResource($resourceClass), $perPage, $message),
            default => self::$defaultMethod($items, $resourceClass, $perPage, $message),
        };
    }

}
