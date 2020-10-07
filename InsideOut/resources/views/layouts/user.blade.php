@extends('layouts.app')


<div class="container-fluid">
    <h1>PROFILO UTENTE</h1>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            @yield('DatiUtente')
        </div>

        <div class="col-3">
            <div class="row">
                <button type="button" onclick="{{ route('login') }}">LOGOUT</button>
            </div>
            <div class="row">
                <button type="button" onclick="{{ route('login') }}">INDIETRO</button>
            </div>
        </div>
    </div>

    @if(Auth::user()->id == $user->id)
                @yield('EliminaAccount')
    @endif

</div>



