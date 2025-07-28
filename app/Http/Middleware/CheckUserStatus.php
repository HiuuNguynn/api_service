<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Helpers\ApiResponse;
use App\Models\Person;
use App\Models\User;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id') ?? $request->input('id');
        if ($id) {
            $person = Person::find($id);
            if (!$person) {
                return ApiResponse::error('Person not found', 404);
            }
            if (isset($person->status) && $person->status == User::STATUS_DEACTIVE) {
                throw new AuthorizationException('Account is deactive');
            }
        }
        return $next($request);
    }
}
