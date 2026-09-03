<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

if (!function_exists('sendResponse')) {
    function sendResponse($result, $message, $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ], $code);
    }
}

if (!function_exists('sendResponsePaginate')) {
    function sendResponsePaginate(LengthAwarePaginator $result, $data, $message, array $attributes = [])
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        $paginateInfo = [
            'from' => $result->firstItem(),
            'to' => $result->lastItem(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'last_page' => $result->lastPage(),
            'per_page' => $result->perPage(),
        ];

        $response['extra'] = !empty($attributes)
            ? array_merge($paginateInfo, $attributes)
            : $paginateInfo;

        return response()->json($response);
    }
}

if (!function_exists('sendSuccess')) {
    function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}

if (!function_exists('sendError')) {
    function sendError($error, $errorMessages = [], $code = 500)
    {
        if (str_contains(strtolower($error), 'tidak ditemukan') || str_contains(strtolower($error), 'not found')) {
            $code = 404;
        }

        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('pagination')) {
    function pagination($query, $limit = null)
    {
        $limit = $limit ?? request()->input('per_page', 10);
        $limit = min((int) $limit, 1000);

        return $query->paginate($limit);
    }
}

/*
 * TODO: Implement these when spatie/laravel-activitylog is installed:
 *
 * if (!function_exists('logActivity')) {
 *     function logActivity($subject, $event, $causer = null, $properties = []) { ... }
 * }
 *
 * TODO: Implement when settings table/package is available:
 *
 * if (!function_exists('setting')) {
 *     function setting($key, $default = null) { ... }
 * }
 */
