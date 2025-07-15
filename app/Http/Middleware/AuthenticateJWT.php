<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\AuthToken;
use App\Models\User;

class AuthenticateJWT
{
    public function handle($request, Closure $next)
    {
        $header = $request->header('Authorization');
        if (!$header || !preg_match('/Bearer\\s(.+)/', $header, $matches)) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        try {
            $payload = AuthToken::decodeAccessToken($matches[1]);
            $user = User::where('email', $payload->email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 401);
            }
            
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        } catch (\Exception) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return $next($request);
    }
}