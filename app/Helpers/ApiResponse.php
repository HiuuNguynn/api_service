<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success( $message = 'Success', $status = 200, $data = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'status' => $status,
        ];
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }
        return response()->json($response, $status);
    }

    public static function error($message = 'Error', $status = 500, $data = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'status' => $status,
        ];
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }
        return response()->json($response, $status);
    }
}
