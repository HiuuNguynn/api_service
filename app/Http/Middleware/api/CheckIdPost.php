<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Helpers\ApiResponse;

class CheckIdPost {
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id') ?? $request->input('id');
        if ($id) {
            $post = Post::find($id);
            if (!$post) {
                return ApiResponse::error('Post not found', 404);
            }
        }
        return $next($request);
    }
}