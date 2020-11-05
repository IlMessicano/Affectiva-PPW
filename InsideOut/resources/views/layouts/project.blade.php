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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $(".collapse_left_bar").click(function(){
                $(".col_left").toggle();
                $("iframe").toggleClass('col-lg-12').toggleClass('col-md-12');
            });

            function cookie(name, value) {

                var curCookie = name + "=" + encodeURIComponent(value);

                document.cookie = curCookie;
            }
            function readCookie(name) {
                document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
            }

            function parseCookies() {
                var flags = {};
                var c = document.cookie;
                if (c === "") {
                    return flags;
                }
                var codeSegments = c.split("; ");
                var i = 0;
                for (;i < codeSegments.length;i++) {
                    var part = codeSegments[i];
                    var index = part.indexOf("=");
                    var key = part.substring(0, index);
                    var value = part.substring(index + 1);
                    value = decodeURIComponent(value);
                    flags[key] = value;
                }
                return flags;
            }
            var accessTextResize = function() {
                function load(scale) {
                    document.body.style.zoom = scale;
                    document.body.style.MozTransform = "scale(" + scale + ")";
                    document.body.style.MozTransformOrigin = "top center";
                }
                var x = 1;
                var value;
                var options = parseCookies();
                if (options.scale == null || typeof options.scale === "undefined") {
                    value = x;
                } else {
                    value = parseFloat(options.scale);
                }
                load(value);
                jQuery("#inc-size").click(function() {
                    value = value + 0.2;
                    load(value);
                    cookie("scale", value);
                });
                jQuery("#dec-size").click(function() {
                    value = value - 0.2;
                    load(value);
                    cookie("scale", value);
                });
                jQuery("#reset-size").click(function() {
                    load(x);
                    readCookie("scale");
                    cookie("scale", x);
                });
            }();
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
<div class="block-body"></div>
<div class="container-fluid h-100 w-100">
    <div class="row w-100 top_nav">
        <a href="{{route('home')}}" style="text-decoration: none" class="fas fa-home fa-2x text-center"></a>
        <i class="fas fa-bars fa-2x text-center collapse_left_bar"></i>
        <div class="sizeing">
            <a id="inc-size">A+</a>
            <a id="dec-size"style="margin-left:0.5rem">A-</a>
            <a id="reset-size"style="margin-left:0.5rem">Reset</a>
        </div>
        <a class="profile" style="background-image: url('{{Auth::user()->imgProfilo}}')" href="{{route('profile',['id'=>Auth::id()])}}"></a>
    </div>
    <div class="row h-100" >
        <div class="col-lg-3 col-md-4 col-sm-12 h-100 col_left">
            <div class="row align-content-center new_things">
                @include('button')
            </div>
            <div class="row project">
                <div class="container-fluid">
                    @yield('project')
                </div>
            </div>
            <div class="row video">
                <div class="container-fluid">
                    @yield('video')
                </div>
            </div>
        </div>

        <div class="col h-100" style="padding:0;overflow-y: auto;z-index: 50;" >
            @yield('content_center')
        </div>
    </div>
</div>
@yield('modals')
</body>
</html>
