<?php

namespace App\Services\Api;

use Illuminate\Http\JsonResponse;

interface ResponseFactoryInterface
{
    /**
     * Make the success response.
     *
     * @param $message
     * @param $data
     * @param int $status
     * @return ResponseFactory|JsonResponse
     */
    public function success($message, $data = null, int $status = JsonResponse::HTTP_OK);

    /**
     * Make the error response.
     *
     * @param $code
     * @param $message
     * @param int $status
     * @param array $errors
     * @return ResponseFactory|JsonResponse
     */
    public function error($code, $message, int $status, array $errors = []);
}
