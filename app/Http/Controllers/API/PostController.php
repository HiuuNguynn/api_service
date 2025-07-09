<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StorePostRequest;
use App\Service\PostService;
use App\Helpers\ApiResponse;

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

    public function create()
    {
        return ApiResponse::success(null, 'Create post form data');
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->validated());
        return ApiResponse::success($post, 'Post created successfully', 200);
    }

    public function show($id)
    {
        $post = $this->postService->getPost($id);
        return ApiResponse::success($post, 'Post fetched successfully');
    }

    public function edit($id)
    {
        $post = $this->postService->getPost($id);
        return ApiResponse::success($post, 'Post fetched successfully');
    }

    public function update(StorePostRequest $request, $id)
    {
        $validated = $request->validated();
        $post = $this->postService->updatePost($validated, $id);
        return ApiResponse::success($post, 'Post updated successfully');
    }

    public function destroy($id)
    {
        $deleted = $this->postService->deletePost($id);
        return ApiResponse::success($deleted, 'Post deleted successfully');
    }

    // public function bulkEdit()
    // {
    //     $posts = $this->postService->getAllPosts();
    //     return ApiResponse::success($posts, 'Posts fetched successfully');
    // }


    // public function bulkUpdate(BulkUpdatePostRequest $request)
    // {
    //     $result = $this->postService->bulkUpdate($request->validated());
    //     return ApiResponse::success($result, 'Posts updated successfully');
    // }
}
