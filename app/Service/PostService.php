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
    public function checkTitleExists(string $title): bool
    {
        return Post::where('title', $title)->exists();
    }

    public function createPost(array $data)
    {
        $title = $this->checkTitleExists($data['title']);
        if ($title) {
            throw new \Exception('Title already exists');
        }
        return Post::create($data);
    }

    public function getPost($id)
    {
        $post = Post::with('person')->find($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }
        return $post;
    }

    public function updatePost(array $data, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }
        if (isset($data['title']) && $data['title'] !== $post->title) {
            if ($this->checkTitleExists($data['title'])) {
                throw new \Exception('Title already exists');
            }
        }
        $post->update($data);
        return $post;
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new \Exception('Post not found');
        }
        return $post->delete();
    }

    public function getAllPosts()
    {
        return Post::all();
    }

    public function bulkUpdate(array $validated): array
    {
        $results = [];

        $posts = $validated['posts'] ?? null;

        if (!is_array($posts) || empty($posts)) {
            return [
                'success' => false,
                'message' => 'Invalid input: posts array required',
                'results' => []
            ];
        }

        foreach ($posts as $postData) {
            $result = $this->updateSinglePost($postData);
            $results[] = $result;
        }

        return $results;
    }


    public function updateSinglePost(array $postData): array
    {
        if (!isset($postData['id'], $postData['title'], $postData['content'])) {
            return [
                'id' => $postData['id'] ?? null,
                'status' => 'invalid data',
                'error' => 'Missing required fields'
            ];
        }

        $post = Post::find($postData['id']);
        if (!$post) {
            return [
                'id' => $postData['id'],
                'status' => 'not found'
            ];
        }

        if ($postData['title'] !== $post->title) {
            $titleExists = Post::where('title', $postData['title'])
                ->where('id', '!=', $post->id)
                ->exists();
            if ($titleExists) {
                return [
                    'id' => $postData['id'],
                    'status' => 'title exists'
                ];
            }
        }

        try {
            $post->update([
                'title' => $postData['title'],
                'content' => $postData['content'],
            ]);
            return [
                'id' => $postData['id'],
                'status' => 'updated'
            ];
        } catch (\Exception $e) {
            return [
                'id' => $postData['id'],
                'status' => 'update failed',
                'error' => $e->getMessage()
            ];
        }
    }


}