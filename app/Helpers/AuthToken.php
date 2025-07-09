<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthToken
{
    public static function decodeAccessToken($token)
    {
        try {
            return JWT::decode(
                $token,
                new Key(config('services.auth.secret_key'), config('services.auth.algorithm'))
            );
        } catch (\Exception $e) {
            throw new ModelNotFoundException(trans('messages.unauthorized'));
        }
    }

    public static function encodeAccessToken($payload)
    {
        return JWT::encode($payload, config('services.auth.secret_key'), config('services.auth.algorithm'));
    }

    public static function getUserIdFromAccessToken($accessToken)
    {
        $payload = self::decodeAccessToken($accessToken);
        return $payload->user_id;
    }
}