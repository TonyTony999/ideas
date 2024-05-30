<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="{{$idea->user->getImageURL()}}" alt="{{$idea->user->name}} Avatar">
                <div>
                    <h5 class="card-title mb-0"><a href={{route('users.show', $idea->user_id)}}> {{$idea->user->name}}
                        <!--since the idea has the user table attached since we set
                            a one to one relationship with the user table we can
                            access the user properties deom the idea itself-->
                        </a></h5>
                </div>
            </div>
            {{--@if(auth()->id()==$idea->user_id)--}}
            @can("delete", $idea)
            <!--we are using the idea-delete gate to check if the current user is able to
            update or delete an idea , only the users with admin role or the creators can update or delete posts,
            we pass the current idea object to the can gate function-->
            <form action="{{ route('ideas.destroy', $idea->id) }}" method="POST">
                <!--To add an id to the subroute we can add it to the second argument of the route function
                     -->
                @csrf
                @method('delete')
                <!--we can add a delete directive so laravel knows the post request is actually a delete one
                    and is able to match it in the web routes file -->
                    <a href={{ route('ideas.edit', $idea->id) }} class="text-secondary text-muted text-decoration-none">Edit</a>
                    <a href={{ route('ideas.show', $idea->id) }} class="text-secondary mx-2 text-muted text-decoration-none">View</a>
                <button class="btn btn-sm bg-danger" type="submit">X</button>
            </form>
            @else
            <a href={{ route('ideas.show', $idea->id) }} class="text-secondary mx-2 text-muted text-decoration-none">View</a>
            {{--@endif--}}
            @endcan

        </div>
    </div>
    <div class="card-body">
        @if($editing ?? false) <!-- if var editing exists use editing val , else editing =false -->
        <form action="{{ route('ideas.update', $idea->id) }}" method="POST">
            @csrf
            @method("put") <!--since this is actually a put request we can tell laravel to search for put
            request in web.php routes -->
            <div class="mb-3">
                <label for="updatedContent"></label>
                <textarea class="form-control" name="updatedContent" id="updatedContent" rows="3">{{$idea->content}}</textarea>
                @error('updatedContent')
                    <div class="fs-6 bg-danger mt-2"> {{ $message }}</div>
                    <!--when there is an error associated with the form field
                            laravel will display an error and the error message will be automatically sourced
                            for us in the message variable -->
                @enderror
            </div>
            <div class="">
                <button class="btn btn-dark" type="submit"> Update </button>
            </div>
        </form>

        @else
        <p class="fs-6 fw-light text-muted">
            {{ $idea->content }}
        </p>
        @endif
        <div class="d-flex justify-content-between">
            @include('likes.like-box')
            <div>
                <span class="fs-6 fw-light text-muted">
                    <span class="fas fa-clock"> </span>
                    {{ $idea->created_at->diffForHumans() }}
                    <!-- this diffforhuman will show a more readable date -->
                </span>
            </div>
        </div>
       @include("shared.comment-box")
    </div>
</div>
