@extends('layout.layout')
@section('title', 'Admin')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('admin.left-sidebar')
            </div>
            <div class="col-9">
                @include('shared.successMessage')
                <h1>users</h1>

                <table class="table table-striped mt-3">
                    <thead class="table-dark">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined At</th>
                        <th>#</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->toDateString() }}</td>
                                <td>
                                    <a href="{{route("users.show", $user->id)}}">Show</a>
                                    <a href="{{route("users.edit", $user->id)}}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
