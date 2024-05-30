@extends('layout.layout')
@section('title', $user->name)
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include("shared.left-sidebar")
            </div>
            <div class="col-6">

                @include("shared.successMessage")
                @include("users.profile-card")

                <hr>
                {{-- dump($editing) --}}
                @if(count($ideas)>0)
                @foreach ($ideas as $idea)
                    <div class="mt-3">
                        @include('ideas.ideaCard')
                    </div>
                @endforeach
                @else
                <p>No results found</p>
                @endif

                    {{-- we can add query strings to the
                        pagination buttons so we dont lose our results when we use the search bar
                        after we click on the buttons --}}
                {{$ideas->links()}}

            </div>

            <div class="col-3">
                @include("shared.search")
                @include("shared.follow-box")
            </div>
        </div>
    </div>
@endsection
