<div class="card overflow-hidden">
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            @auth()

            <li class="nav-item">
                <a class="{{ Route::is('admin.dashboard') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href='{{ route('dashboard') }}'>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="{{ Route::is('admin.users') ? 'text-white bg-primary rounded' : '' }} nav-link"
                    href='{{ route('admin.users') }}'>
                    <span>Users</span></a>
            </li>

            @endauth

        </ul>
    </div>
    <div class="card-footer text-center py-2">
        @auth
        <a class="btn btn-link btn-sm" href={{ route('lang',"en") }}>EN </a>
        <a class="btn btn-link btn-sm" href={{ route('lang',"es") }}>ES </a>
        @endauth
        @guest
        <a class="btn btn-link btn-sm" href={{ route('lang',"en") }}>EN </a>
        <a class="btn btn-link btn-sm" href={{ route('lang',"es") }}>ES </a>
        @endguest

    </div>
</div>
