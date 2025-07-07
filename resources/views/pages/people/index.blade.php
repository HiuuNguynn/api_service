@extends('layouts.app')

@section('content')
    <a href="{{ route('people.create') }}" class="btn btn-info">Add Person</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID_USER</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->id_user }}</td>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->email }}</td>
                    <td>{{ $person->phone }}</td>
                    <td>{{ $person->address }}</td>
                    <td>
                        <a href="{{ route('people.edit', $person->id_user) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('people.destroy', $person->id_user) }}" method="POST" style="display:inline;">
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
        {{ $people->links('pagination::bootstrap-4') }}
    </div>
@endsection
