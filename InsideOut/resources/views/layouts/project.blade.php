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
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $(".collapse_left_bar").click(function(){
                $(".col_left").toggle();
            });
            // $(window).bind("resize", function () {
            //         if ($(this).width() < 700) {
            //             $('.collapse_left_bar').removeClass('fa-2x')
            //         } else {
            //             $('.collapse_left_bar').addClass('fa-2x')
            //         }
            //     }).resize();
        });
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout_project.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    @yield('head')

</head>
<body>
<div class="container-fluid h-100 w-100" >
    <div class="row w-100 top_nav align-content-center">

            <i class="fas fa-bars fa-2x text-center collapse_left_bar"></i>
        <div class="col-4 offset-lg-3 offset-md-4 offset-sm-12 "><a href="#">Progetto</a> < <a href="#">Task</a> < <a href="#">Video</a></div>
            <div class="profile" style="background-image: url('{{Auth::user()->imgProfilo}}')"></div>

    </div>
    <div class="row h-100" >
        <div class="col-lg-3 col-md-4 col-sm-12 h-100 col_left">
            <div class="row align-content-center new_things">
                @yield('button')
            </div>
        </div>
    </div>
</div>
</body>
</html>
