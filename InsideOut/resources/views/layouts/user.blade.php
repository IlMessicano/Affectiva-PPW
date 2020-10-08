@extends('layouts.app')

<link href="{{ asset('css/profile.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            @yield('DatiUtente')
        </div>

        <div class="col-3">
            <div class="row">
                <a  class="btn btn-block btn-profile" href="{{ route('logout') }}">Logout</a>
            </div>

            <div class="row">
                <a class="btn btn-block btn-profile" onclick="goBack()">Indietro</a>
            </div>
        </div>
    </div>

    @if($user->id !=null )
        @if(Auth::user()->id == $user->id)
                @yield('EliminaAccount')
        @endif

    @endif

</div>



