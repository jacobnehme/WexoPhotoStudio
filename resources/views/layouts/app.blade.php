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
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'WexoPhotoStudio') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <ul class="navbar-nav mr-auto">
                    @auth
                        @switch(auth()->user()->role_id)
                            @case(\App\Role::admin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ action('ProductController@index')}}">
                                    Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ action('OrderController@all')}}">
                                    Orders
                                </a>
                            </li>
                            @break
                            @case(\App\Role::customer())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ action('OrderController@create')}}">
                                    Order
                                </a>
                            </li>
                            @break
                            @default
                        @endswitch
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links + more -->
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
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ auth()->user()->email .
                                ' (' . ucfirst(auth()->user()->role()->title) . ')' }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                @switch(auth()->user()->role_id)
                                    @case(\App\Role::customer())
                                    <a class="dropdown-item"
                                       href="{{ action('CustomerController@edit',  auth()->user()->customer()->id)}}">
                                        My Account
                                    </a>
                                    @break
                                    @case(\App\Role::photographer())
                                    <a class="dropdown-item"
                                       href="{{ action('PhotographerController@edit',  auth()->user()->photographer()->id)}}">
                                        My Account
                                    </a>
                                    @break
                                    @default
                                @endswitch

                                @if(auth()->user()->role_id == \App\Role::customer() or auth()->user()->role_id == \App\Role::photographer())
                                    <a class="dropdown-item" href="{{ action('OrderController@index')}}">
                                        My Orders
                                    </a>
                                @endif

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

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
