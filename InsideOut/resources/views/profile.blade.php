@extends('layouts.user')

@section('DatiUtente')
    @foreach ($user as $user)
        <div class="row"><div class="col-9"><p>Nome: {{ $user->name }} </p></div></div>
        <div class="row"><div class="col-9"><p>E-mail: {{ $user->email }} </p></div></div>
        <div class="row"><div class="col-9"><p>Data di nascita: {{ $user->datanascita }} </p></div></div>
    @endforeach
@endsection

@section('EliminaAccount')
    <div class="row">
        <h1>Elimina Account</h1>
        <br>
        <button type="button" onclick="{{ route('login') }}">ELIMINA</button>
    </div>
@endsection
