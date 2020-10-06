<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>InsideOut</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/login_register.css') }}" rel="stylesheet">

</head>
<body>
        @if (Route::has('login'))
            <div class="row justify-content-end" style="margin:0.5rem 0.8rem auto">
                <div class="col-1 links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    </div>
                    <div class="col-1 links">
                        <a href="{{ url('/') }}">Profilo</a>
                    </div>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                        @if (Route::has('register'))
                        <div class="col-1 links">
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
        @endif
    @yield('content')
</body>
</html>
