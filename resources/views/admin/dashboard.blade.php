@extends('layout.layout')
@section('title', 'Admin')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include("admin.left-sidebar")
            </div>
            <div class="col-9">
                @include("shared.successMessage")
                <h1>Admin</h1>
            </div>
        </div>
    </div>
@endsection

