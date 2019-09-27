<ul class="navbar-nav ml-auto">
@guest
    @if (\Route::has('login'))
        <!-- Authentication Links -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>&nbsp;@lang('app::links.login')</a>
        </li>
        {{--<li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>&nbsp;@lang('app::links.register')</a>
        </li>--}}
    @endif
@else
    <li class="nav-item dropdown">
        <a id="navbarDropdownUser" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $userName }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUser">
            <div class="dropdown-item-text">
                <b>{{ $userName }}</b><br/>
                <small>{{ $userEmail }}</small><br/>
            </div>
            @can('user.can_edit_profile')
                @if (\Route::has('profile/edit'))
                    <a class="dropdown-item" href="{{ route('profile/edit') }}">
                        @lang('app::links.profile')
                    </a>
                @endif
            @endcan
            @if (\Route::has('logout'))
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('frmLogout').submit();">
                    <i class="fas fa-sign-out-alt"></i>&nbsp;@lang('app::links.logout')
                </a>
                <form id="frmLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
        </div>
    </li>

    <li class="nav-item dropdown">
        <a id="navbarDropdownHelp" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownHelp">
            @can('user.can_view_phpinfo')
                @if (\Route::has('phpinfo'))
                    <a class="dropdown-item" href="{{ route('phpinfo') }}">@lang('app::links.phpinfo')</a>
                @endif
            @endcan
            @if (\Route::has('about'))
                <a class="dropdown-item" href="{{ route('about') }}">@lang('app::links.about')</a>
            @endif
        </div>
    </li>
@endguest
</ul>
