    <div class="card">
        <div class="px-3 pt-4 pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img style="width:150px" class="me-3 avatar-sm rounded-circle" src="{{ $user->getImageURL() }}"
                        alt="{{ $user->name }} Avatar">
                    <div>
                        <h3 class="card-title mb-0"><a href="#"> {{ $user->name }}
                            </a></h3>
                        <span class="fs-6 text-muted">@ {{ $user->name }}</span>
                    </div>
                </div>
                @auth
                    @can("update", $user)
                    <!--if the user has an update policy then show the edit route
                    this policy also makes sure that the use is authenticated-->
                        <a href={{ route('users.edit', $user->id) }}>Edit</a>
                    @endcan
                @endauth
            </div>
            <div class="px-2 mt-4">

                <h5 class="fs-5"> About : </h5>
                <p class="fs-6 fw-light">
                    {{ $user->bio ?? 'fill your bio' }}
                </p>
                <div class="d-flex justify-content-start">
                    <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-user me-1">
                        </span>Followers: {{ $user->followers()->count() }} </a>
                    <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
                        </span> {{ $user->ideas->count() }} </a>
                    <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-comment me-1">
                        </span> {{ $user->comments->count() }} </a>
                    <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-heart me-1">
                        </span> {{ $user->likes()->count() }} </a>
                </div>
                @auth()
                    <!-- if the current session id is not the same as the users profile id then
                                                dont show the follow button , else show it-->

                    {{--@if(!Auth::user()->is($user)) we can also do this --}}

                    {{--@if (Auth::id() !== $user->id)-- we can use this method or the line above it }}
                        {{-- auth id is the current authenticated users id and $user id is the user id of the profile --}}

                        @if(Auth::user()->isNot($user)) {{--or we can also do this instead! --}}

                        @if (Auth::user()->follows($user))
                            <form action="{{ route('users.unfollow', $user->id) }}" method="POST">
                                @csrf
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-danger btn-sm"> Unfollow </button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('users.follow', $user->id) }}" method="POST">
                                @csrf
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm"> Follow </button>
                                </div>
                            </form>
                        @endif

                        {{-- dump(Auth::user()->follows($user)) --}}
                    @endif
                @endauth

            </div>
        </div>
    </div>
