<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WexoPhotoStudio') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body @auth class="{{auth()->user()->isRole('photographer') ? 'bg-dark' : ''}}" @endauth>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                WexoPhotoStudio
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @component('components.leftNav')
                    @endcomponent
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
{{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                Notifications--}}
{{--                                <span class="caret"></span>--}}
{{--                            </a>--}}

{{--                            <div class="notifications dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}

{{--                            </div>--}}
{{--                        </li>--}}

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ auth()->user()->email .
                                ' (' . ucfirst(auth()->user()->role()->title) . ')' }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                @component('components.rightNav')
                                @endcomponent

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="main">
        {{$slot}}
    </main>
</div>
</body>
</html>
