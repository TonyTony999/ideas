@extends('layout.layout')
@section('title', 'Idea')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include("shared.left-sidebar")
            </div>
            <div class="col-6">

                @include("shared.successMessage")
               {{-- @include("shared.submitIdea") --}}
                @include("ideas.ideaCard")
            </div>

            <div class="col-3">
                @include("shared.search")
                @include("shared.follow-box")
            </div>
        </div>
    </div>
@endsection
