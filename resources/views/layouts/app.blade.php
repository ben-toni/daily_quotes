<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Translate -->
    <script>
        window.default_locale = "{{ config('app.lang') }}";
        window.fallback_locale = "{{ config('app.fallback_locale') }}";
        window.messages = @json(returnLocalizationMessage());
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="grey-bg">
<div id="app">
    @auth
        <nav class="container navbar navbar-expand-lg navbar-light navbar-laravel mb-4">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand logo-nav" href="{{ url('/') }}"><i class="fas fa-quote-right"></i></a>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item {{ Request::path() == 'admin/users' ? 'active-bold' : ''  }}">
                        <a class="nav-link a-green font-16" href="{{url('/admin/users')}}">{{ __('general.users') }}</a>
                    </li>
                    <li class="nav-item {{ Request::path() == 'admin/quotes' ? 'active-bold' : ''  }}">
                        <a class="nav-link a-green font-16" href="{{url('/admin/quotes')}}">{{ __('general.quotes') }}</a>
                    </li>
                </ul>

                <a id="navbarDropdown" data-target="#userDropdown" class="nav-link dropdown-toggle a-green font-16 p-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="form-inline dropdown-menu dropdown-menu-left dropdown-menu-sm-right" id="userDropdown" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('auth.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
    @endauth

    <main class="mb-5">
        @yield('content')
    </main>
</div>
</body>
</html>
