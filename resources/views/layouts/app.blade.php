<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                      <li><a href="{{ route('posts.index') }}">@lang('header.posts')</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">@lang('header.login')</a></li>
                            <li><a href="{{ route('register') }}">@lang('header.register')</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    @lang('header.notifications') <span class="badge">{{count(Auth::user()->unreadNotifications)}}</span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        @forelse (Auth::user()->unreadNotifications as $notification)
                                            <a href="{{ route('posts.show', $notification->data['post']['id']) }}">@lang('header.hascommented', ['user' => $notification->data["user"]["name"], 'post' => $notification->data["post"]["title"]])</a>
                                        @empty
                                            <b class="text-center center-block">No notifications</b>
                                        @endforelse
                                    </li>
                                </ul>
                            </li>
                            @role('administrator')
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        @lang('header.administration') <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('admin.users.index') }}">
                                                Users
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            <img width="20px" height="20px" src="{{ asset('uploads/avatars/'.Auth::user()->avatar) }}"> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('user.profile') }}">
                                            Profile
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li><a href="{{ route('change_lang', ['lang' => 'es']) }}">ES</a></li>
                        <li><a href="{{ route('change_lang', ['lang' => 'en']) }}">EN</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
