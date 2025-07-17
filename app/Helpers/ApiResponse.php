<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success( $message = 'Success', $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'status' => $status,
        ];
        return response()->json($response, $status);
    }

    public static function error($message = 'Error', $status = 500): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'status' => $status,
        ];
        return response()->json($response, $status);
    }
}
