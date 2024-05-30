<div class="card">
    <div class="px-3 pt-4 pb-2">
        <img style="width:150px" class="me-3 avatar-sm rounded-circle"
            src="{{$user->getImageURL()}}" alt="Mario Avatar">

        <div class="d-flex align-items-center justify-content-between w-100">

            <div class="d-flex align-items-center w-100">

                <form action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data"  method="POST" class="w-100">

                    @csrf
                    @method('put')
                    <div class="mt-3 px-2">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ $user->name }}">
                        @error('name')
                            <div class="fs-6 bg-danger mt-2"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 px-2 w-100">
                        <label for="bio">Bio
                            <textarea class="form-control" cols=100 name="bio"> {{ $user->bio ?? 'enter your bio' }}</textarea>
                        </label>
                        @error('bio')
                            <div class="fs-6 bg-danger mt-2"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 px-2">
                        <label for="image">Profile Picture</label>
                        <input type="file" name="image" class="form-control">
                        @error('image')
                            <div class="fs-6 bg-danger mt-2"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 px-2 align-self justify-self">
                        <button type ="submit" class="btn btn-sm btn-primary">
                            Update
                        </button>
                        <a type="text-decoration-none" href="{{ route('profile') }}">View</a>
                    </div>

                </form>

            </div>
        </div>
        <div class="px-2 mt-4">


            <div class="d-flex justify-content-start">
                <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-user me-1">
                    </span> 0 Followers </a>
                <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
                    </span> {{ $user->ideas->count() }} </a>
                <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-comment me-1">
                    </span> {{ $user->comments->count() }} </a>
            </div>
            @auth()
                <!-- if the current session id is not the same as the users profile id then
                                                    dont show the follow button , else show it-->
                @if (Auth::id() !== $user->id)
                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm"> Follow </button>
                    </div>
                @endif
            @endauth

        </div>
    </div>
</div>
