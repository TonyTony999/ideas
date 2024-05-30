<div class="card">
    <div class="card-header pb-0 border-0">
        <h5 class="">Search</h5>
    </div>
    <div class="card-body">
        <form action="{{route('dashboard')}}">
            @csrf
            <!--we can display waht was displayed for in the search bar by including
            the value of the request of this input name , in this case search-->
        <input type="text" value="{{request('search')}}" placeholder="..." class="form-control w-100" name="search" id="search">
        <button class="btn btn-dark mt-2" type="submit"> Search</button>
    </form>
    </div>
</div>
