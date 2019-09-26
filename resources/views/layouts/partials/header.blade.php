<nav class="navbar navbar-expand navbar-dark fixed-top bg-dark flex-column flex-md-row">
    <a class="navbar-brand" href="{{ \Route::has('index') ? route('index') : '/' }}">{{ config('app.name', 'Laravel') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    @if(app()->isDownForMaintenance())
        <div class="alert alert-warning" role="alert">
            <b>@lang('app::warnings.maintenance')</b>
        </div>
    @endif

    <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Left Side nav-bar content -->
        @include('layouts::partials.leftHeaderNavBar')

        <!-- Right Side nav-bar content -->
        @include('layouts::partials.rightHeaderNavBar')
    </div>
</nav>
