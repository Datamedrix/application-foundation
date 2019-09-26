<ul class="navbar-nav mr-auto">
    @auth
        @if(\Route::has('home'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> <span class="sr-only">(current)</span></a>
            </li>
        @endif
    @endauth
</ul>
