<?php

namespace App\Service;

use App\Models\Post;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponse;
use App\Jobs\LogPersonActionJob;


class PostService
{
    public function createPost(array $data)
    {
        return Post::create($data);
    }

    public function getPost($id)
    {
        $post = Post::with('person')->find($id);
        return $post;
    }

    public function updatePost(array $data, $id)
    {
        $post = Post::find($id);
        $post->update($data);
        return $post->fresh();
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        return $post->delete();
    }

    public function getAllPosts()
    {
        return Post::all();
    }


}