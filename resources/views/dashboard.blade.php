@extends('layout.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('shared.left-sidebar')
            </div>
            <div class="col-6">

                @include('shared.successMessage')
                @include('ideas.submitIdea')
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
                {{$ideas->withQueryString()->links()}}


                <!--here we create the pagination buttons , by default laravel uses tailwind
                    to style the buttons . if we want to use bootstrap we can go app/providers/appserviceproviders.php
                    and add Paginator::useBootstrapFive();
                  -->
            </div>

            <div class="col-3">
                @include('shared.search')
                @include('shared.follow-box')
            </div>
        </div>
    </div>
@endsection
