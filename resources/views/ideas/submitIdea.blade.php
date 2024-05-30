@auth()
<h4> {{__('ideas.share_ideas') }} </h4>
<div class="row">
    <form action="{{ route('ideas.create') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="content"></label>
            <textarea class="form-control" name="content" id="content" rows="3"></textarea>
            @error('content')
                <div class="fs-6 bg-danger mt-2"> {{ $message }}</div>
                <!--when there is an error associated with the form field
                        laravel will display an error and the error message will be automatically sourced
                        for us in the message variable -->
            @enderror
        </div>
        <div class="">
            <button class="btn btn-dark" type="submit"> Share </button>
        </div>
    </form>
</div>
@endauth
@guest()
    <h2>{{__('ideas.login_to_share') }}</h2>
    {{-- __(filename.keyname) this function will look into the lang folder and it will load the filename
        depending on the locale that we set in the env file and it will look for the keyname to display
        the value  --}}

    {{--We can also use:
        @lang('ideas.login_to_share')
        and
        trans('ideas.login_to_share')

        It will do the same--}}
@endguest
