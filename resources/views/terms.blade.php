@extends("layout.layout")
@section('content')

    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('shared.left-sidebar')
            </div>
            <div class="col-6">

                <hr>

                <h1 class="lead">
                    terms
                </h1>
                <div class="container-lg">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit doloremque quo similique dolorum voluptatum,
                    mollitia cumque? Maiores autem, nostrum nemo aliquid magni praesentium in a, accusantium eius, iure optio
                    dolorem.
                </div>
            </div>

            <div class="col-3">
                @include('shared.search')
                @include('shared.follow-box')
            </div>
        </div>
    </div>
@endsection




{{-- to actually paste the content pf the view inside the layout file we have to wrap it around
    a section  and make sure the yield name matches the section name--}}
