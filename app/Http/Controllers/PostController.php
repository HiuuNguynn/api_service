<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('person')->paginate(4);
        return view('pages.Post.index', compact('posts'));
    }

    public function create()
    {
        $people = Person::all();
        return view('pages.Post.create', compact('people'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        Post::create($validated);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $people = Person::all();
        return view('pages.Post.edit', compact('post', 'people'));
    }

    public function update(StorePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validated(); 
        $post->update($validated);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function bulkEdit()
    {
        $posts = Post::paginate(10);
        return view('pages.Post.bulk_edit', compact('posts'));
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->input('posts', []);
        DB::transaction(function () use ($data) {  
            foreach ($data as $item) {
                Post::where('id', $item['id'])->update([
                    'title' => $item['title']
                ]);
            }
        });

        return redirect()->route('posts.index')->with('success', 'All posts updated successfully.');
    }
}
