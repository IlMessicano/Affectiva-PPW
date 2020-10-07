@extends('layouts.app')

<div class="container-fluid">
    <h1>PROFILO UTENTE</h1>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="row">
                <p>Nome: @yield('NomeUtente')</p>
            </div>
            <div class="row">
                <p>Email: @yield('EmailUtente')</p>
            </div>
            <div class="row">
                <p>Altro: </p>
            </div>
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

    <div class="row">
        <div class="col-12">
            @if(@Auth::check())
                @yield('EliminaAccount')
            @else
                @yield('SegnalaUtente')
        </div>
    </div>

</div>



