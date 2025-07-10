<?php

namespace App\Services;

use App\Services\Api\ResponseFactory;
use App\Services\Api\ResponseFactoryInterface;

class Service
{
    /**
     * Get ResponseFactory.
     *
     * @return ResponseFactory
     */
    public static function response()
    {
        return app(ResponseFactoryInterface::class);
    }
}
