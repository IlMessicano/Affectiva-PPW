@extends('layouts.app')
@section('head')

    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">

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
@endsection

@if (Session::get('yes'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ Session::get('yes') }}
    </div>
@endif
@if (Session::get('no'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('no') }}
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            @yield('DatiUtente')
        </div>
        <div class="sizeing">
            <a id="inc-size">A+</a>
            <a id="dec-size"style="margin-left:0.5rem">A-</a>
            <a id="reset-size"style="margin-left:0.5rem">Reset</a>
        </div>
        <div class="col-3" style="margin-top:6rem">
            <div class="row">
                <a class="btn btn-block btn-profile" href="{{route('home')}}">Home</a>
            </div>
            @if(Auth::user()->id == $user->id)
                <div class="row">
                    <a  class="btn btn-block btn-profile" href="{{ route('logout') }}">Logout</a>
                </div>
            @endif
        </div>
    </div>

    @if($user->id !=null )
        @if(Auth::user()->id == $user->id)
            @yield('EliminaAccount')
        @endif

    @endif

</div>



