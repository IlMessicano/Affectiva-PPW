@extends('layouts.app')
@section('head')

    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">

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

        <div class="col-3">
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



