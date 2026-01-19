<?php

namespace App\Support\Traits\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    public function responseData(mixed $data, int $code = 200, ?string $msg = '', bool $status = true): JsonResponse
    {
        return $this->handleResponse($data, $status, $code, $msg);
    }

    public function responsePaginated(array $data, int $code = 200, ?string $msg = '', bool $status = true): JsonResponse
    {
        if ((isset($data?->resource) || isset(reset($data)?->resource)) && reset($data)?->resource instanceof LengthAwarePaginator) {
            return $this->handlePaginatedResponse(reset($data), $status, $code, $msg);
        }
        if ((isset($data->resource) || isset(reset($data)->resource)) && reset($data)->resource instanceof CursorPaginator) {

            return $this->handleCursorPaginatedResponse(reset($data), $status, $code, $msg);
        }

        return $this->handleResponse($data, $status, $code, $msg);
    }

    public function responseError(array $data = [], int $code = 404, ?string $msg = '', string $key = 'data'): JsonResponse
    {
        return $this->handleResponse($data, false, $code, $msg, key: $key);
    }

    public function handleResponse(mixed $data, bool $status, int $code, ?string $msg = '', array $headers = [], $key = 'data'): JsonResponse
    {
        $res = [
            'status' => $status,
            'code' => $code,
            'message' => $msg,

        ];
        if ($key != 'nodata')
            $res[$key] = $data;

        return response()->json($res, $code, $headers);
    }

    protected function errorResponse(int $code, string $msg = ''): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
            'data' => null,
        ], $code);
    }

    public function returnValidationError($validator): JsonResponse
    {
        return $this->responseError($validator->errors()->toArray(), 422, 'validation error');
    }

    public function handlePaginatedResponse($data, bool $status, int $code, $msg = '', array $headers = []): JsonResponse
    {
        //Set pagination data
        $isFirst = $data->onFirstPage();
        $isLast = $data->currentPage() === $data->lastPage();
        $isNext = $data->hasMorePages();
        $isPrevious = (($data->currentPage() - 1) > 0);

        $current = $data->currentPage();
        $last = $data->lastPage();
        $next = ($isNext ? $current + 1 : null);
        $previous = ($isPrevious ? $current - 1 : null);

        //Set extra
        $extra = [
            'pagination' => [
                'meta' => [
                    'page' => [
                        'current' => $current,
                        'first' => 1,
                        'last' => $last,
                        'next' => $next,
                        'previous' => $previous,

                        'per' => $data->perPage(),
                        'from' => $data->firstItem(),
                        'to' => $data->lastItem(),

                        'count' => $data->count(),
                        'total' => $data->total(),

                        'isFirst' => $isFirst,
                        'isLast' => $isLast,
                        'isNext' => $isNext,
                        'isPrevious' => $isPrevious,
                    ],
                ],
                'links' => [
                    'path' => $data->path(),
                    'first' => $data->url(1),
                    'next' => ($isNext ? $data->url($next) : null),
                    'previous' => ($isPrevious ? $data->url($previous) : null),
                    'last' => $data->url($last),
                ],
            ],
        ];
        $response = [
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        ];
        //Set extra response data
        if ((bool)count($extra)) {
            $response = array_merge($response, $extra);
        }

        return response()->json($response, $code, $headers);
    }

    public function handleCursorPaginatedResponse($data, bool $status, int $code, $msg = '', array $headers = []): JsonResponse
    {

        //Set pagination data
        $isFirst = $data->onFirstPage();
        $isLast = $data->onLastPage();

        //Set extra
        $extra = [
            'pagination' => [
                'meta' => [
                    'page' => [

                        'per' => $data->perPage(),
                        'count' => $data->count(),
                        'isFirst' => $isFirst,
                        'isLast' => $isLast,
                    ],
                ],
                'links' => [
                    'path' => $data->path(),
                    'next' => $data->nextPageUrl(),
                    'previous' => $data->previousPageUrl(),

                ],
            ],
        ];
        $response = [
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        ];
        //Set extra response data
        if ((bool)count($extra)) {
            $response = array_merge($response, $extra);
        }

        return response()->json($response, $code, $headers);
    }
}
