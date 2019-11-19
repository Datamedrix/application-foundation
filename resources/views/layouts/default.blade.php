<!DOCTYPE html>
<html lang="{{ $locale->language() ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="no-index,no-follow" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <base href="/" target="_self" />
    <meta name="csrf-token" content="{{ csrf_token() }}"><!-- CSRF Token -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    @section('styles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            #app {
                position: relative;
                width: 100%;
                height: 100%;
            }
            .content-wrapper {
                padding-top: 55px;
            }
            .content-wrapper #app-content {
                padding-top: 15px;
            }
        </style>
    @show
    <!-- \Styles -->

    @inject('passportService', 'DMX\\Application\\Services\\PassportService')

    <!-- Scripts -->
    @section('bootstrap-scripts')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/18492bd25d.js" crossorigin="anonymous"></script>
    @show
    <!-- \Scripts -->

    <!-- Global variables -->
    <script>
        window.App = {
            baseUrl: '{{ url('/') }}',
            baseApiUrl: '{{ url('/api/v1') }}',
            env: '{{ config('app.env') }}',
            isDownForMaintenance: {{ app()->isDownForMaintenance() ? 'true' : 'false' }},
            locale: {
                language: '{{ $locale->language() ?? 'en' }}',
                territory: '{{ $locale->territory()  ?? 'GB' }}',
            },
            current: {
                'route': '{{ $currentRoute['name'] }}',
                'url': '{{ $currentRoute['url'] }}',
                'layout': '{{ $layout ?? '' }}',
            },
        };

        @auth
            window.App.Auth = {
            accessToken: '{{ $passportService->getAccessToken() }}',
            refreshToken: null,
            accessTokenExpiresAt: '{{ $passportService->getAccessTokenExpiresAt()->toIso8601String() }}',
            accessTokenExpiresIn: {{ $passportService->getAccessTokenExpiresInSeconds() }}, // seconds
            clientId: '{{ $passportService->getClientId() }}',
        };
        @else
            window.App.Auth = {
            accessToken: null,
            refreshToken: null,
            accessTokenExpiresAt: null,
            accessTokenExpiresIn: null, // seconds
            clientId: '{{ $passportService->getClientId() }}',
        };
        @endauth

        @yield('variables')
    </script>
    <!-- \Global variables -->
</head>
<body class="@yield('body-classes', '')">
<a id="page-top"></a>
<div id="app">
    <!-- HEADER -->
    <header id="app-header">
        @section('header')
            @include('layouts::partials.header')
        @show
    </header>
    <!-- /HEADER -->

    <!-- MAIN - CONTENT -->
    <div class="container-fluid content-wrapper">
        @section('content-wrapper')
            <div class="row flex-xl-nowrap">
                @include('layouts::partials.contentArea')
            </div>
        @show
    </div>
    <!-- /MAIN - CONTENT -->

    <!-- FOOTER -->
    <footer id="app-footer">
        @yield('footer')
    </footer>
    <!-- /FOOTER -->
</div>

<!-- Scripts -->
@section('scripts')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@show
@if(config('app.env') === 'local' && config('app.development') === true)
    <script src="http://localhost:35729/livereload.js"></script>
@endif
<!-- \Scripts -->
</body>
