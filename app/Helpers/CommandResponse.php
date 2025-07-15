<?php

namespace App\Helpers;

class CommandResponse
{
    public static function success($message)
    {
        return [
            'success' => true,
            'message' => $message,
        ];
    }

    public static function error($message)
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}