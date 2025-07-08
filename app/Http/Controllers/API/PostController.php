<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\BulkUpdatePostRequest;
use App\Service\PostService;
use App\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return ApiResponse::success($posts, 'Posts fetched successfully');
    }

    public function store(StorePostRequest $request)
    {
        try {
            $validated = $request->validated();
            $post = $this->postService->createPost($validated);
            return ApiResponse::success($post, 'Post created successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function show($id)
    {
        try {
            $post = $this->postService->getPost($id);
            return ApiResponse::success($post, 'Post fetched successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function edit($id)
    {
        try {
            $post = $this->postService->getPost($id);
            return ApiResponse::success($post, 'Post fetched successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $post = $this->postService->updatePost($validated, $id);
            return ApiResponse::success($post, 'Post updated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->postService->deletePost($id);
            return ApiResponse::success($deleted, 'Post deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function bulkEdit()
    {
        try {
            $posts = $this->postService->getAllPosts();
            return ApiResponse::success($posts, 'Posts fetched successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function checkTitle(Request $request)
    {
        $title = $request->input('title');
        if (!$title) {
            return ApiResponse::error('Title is required', 400);
        }

        $exists = $this->postService->checkTitleExists($title);
        return ApiResponse::success($exists, $exists ? 'Title already exists' : 'Title is available');
    }

    public function bulkUpdate(BulkUpdatePostRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = $this->postService->bulkUpdate($validated);
            return ApiResponse::success($result, 'Posts updated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }
}
