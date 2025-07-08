<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Helpers\ApiResponse;
class CheckUserId
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id') ?? $request->input('id');
        if ($id) {
            $person = Person::find($id);
            if (!$person) {
                return ApiResponse::error('Person not found', 404);
            }
        }
        return $next($request);
    }
}
