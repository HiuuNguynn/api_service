@extends('layouts.app')

@section('content')
    <form action="{{ route('posts.bulkUpdate') }}" method="POST">
        @csrf

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $index => $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <input type="hidden" name="posts[{{ $index }}][id]" value="{{ $post->id }}">
                            <input type="text" name="posts[{{ $index }}][title]" value="{{ $post->title }}" class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Update All</button>
    </form>
@endsection
