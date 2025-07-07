@extends('layouts.app')

@section('content')
    <a href="{{ route('posts.create') }}" class="btn btn-info mb-2">Add Post</a>
    <a href="{{ route('posts.bulkEdit') }}" class="btn btn-primary mb-2">Edit Multiple Posts</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Person Name</th>
                <th>Title</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id_post ?? $post->id ?? $post->getKey() }}</td>
                    <td>{{ $post->person->name }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id_post ?? $post->id ?? $post->getKey()) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id_post ?? $post->id ?? $post->getKey()) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection
