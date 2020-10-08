@extends('layouts.user')


@section('DatiUtente')
    @foreach ($user as $user)
            <div class="avatar-preview-profile" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')"></div>
            <div class="container-fluid userDetails">
            <div class="row"><div class="col-9"><p><b>Nome:</b> {{ $user->nome }} </p></div></div>
                <div class="row"><div class="col-9"><p><b>Cognome:</b> {{ $user->cognome }} </p></div></div>
            <div class="row"><div class="col-9"><p><b>E-mail:</b> {{ $user->email }} </p></div></div>
        <div class="row"><div class="col-9"><p><b>Data di nascita:</b> {{ $user->dataNascita }} </p></div></div>
            </div>
    @endforeach
@endsection

@section('EliminaAccount')
    <div class="row" style="display: block; margin-top:3%">
        <h1 style="color:#ff0000; margin-left: 2%">Elimina Account</h1>
        <div style="background-color:#ff0000; margin-left: 2%; height:1px; width:60%;"></div>
        <button class="btn-delete" type="button" onclick="{{ route('login') }}">Elimina</button>
    </div>
@endsection
