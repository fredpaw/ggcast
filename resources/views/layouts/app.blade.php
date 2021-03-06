<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! SEO::generate() !!}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The SGCast</title>

    <!-- Styles -->
    <link href="{{ asset('css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/thesaas.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon') }}">
    <link rel="icon" href="{{ asset('img/favicon.png') }}">

    @yield('head-scripts')
</head>
<body>
    <div id="app">
        
        <!-- Topbar -->
        <nav class="topbar topbar-inverse topbar-expand-md topbar-sticky">
            <div class="container">

                <div class="topbar-left">
                    <button class="topbar-toggler">&#9776;</button>
                    <a class="topbar-brand" href="/">
                        <img class="logo-default" src="{{ asset('img/logo.png') }}" alt="logo">
                        <img class="logo-inverse" src="{{ asset('img/logo-light.png') }}" alt="logo">
                    </a>
                </div>

                <div class="topbar-right">
                    <ul class="topbar-nav nav">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        @auth
                            @admin
                            <li class="nav-item"><a href="{{ route('series.index') }}" class="nav-link">All series</a></li>
                            <li class="nav-item"><a href="{{ route('series.create') }}" class="nav-link">Create series</a></li>
                            @else

                            @endadmin
                        
                        <li class="nav-item">Hey &nbsp;<a href="/profile/{{auth()->user()->username}}">{{ auth()->user()->name }}</a></li>
                        <li class="nav-item"><a href="/logout">Logout</a></li>
                        @endauth

                        @guest
                        <li class="nav-item"><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#LoginModal">Login</a></li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>
        <!-- END Topbar -->

        <!-- Header -->
        @yield('header')
        <!-- END Header -->

        <!-- Main container -->
        <main class="main-content">

            @yield('content')

        </main>
        <!-- END Main container -->

        <vue-noty></vue-noty>

        @guest
          <vue-login></vue-login>
        @endguest

        <!-- Footer -->
        <footer class="site-footer">
            <div class="container">
                <div class="row gap-y justify-content-center">
                    <div class="col-12 col-lg-6">
                        <ul class="nav nav-primary nav-hero">
                            <li class="nav-item hidden-sm-down">
                                <a class="nav-link" href="/">SGcasts</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/core.min.js') }}"></script>
    <script src="{{ asset('js/thesaas.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('foot-scripts')
</body>
</html>
