@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/login_register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-3">Inside Out</h1>
        <div class="row" style="margin-top:5%">
            <div class="col-md-6">
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="avatar-preview" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')">
                    </div>
                    <div style="position:relative; top:-60px;" class="form-group">
                        <input type="email" title="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div style="position:relative; top:-60px;"class="form-group">
                        <input type="password" title="password" name="password" placeholder="Password" class="form-control @error('email') is-invalid @enderror" required autocomplete="current-password">
                    </div>
                    <div class="form-group" style="position:relative; top:-60px;"><button type="submit"  class="btn btn-block" value="Accedi">Accedi</button></div>
                    <div class="form-group" style="position:relative; top:-60px;"><a class="btn btn-block" href="{{ route('register') }}">Registrati</a></div>
                </form>
            </div>
            <div class="col-md-6">
                <a class="live" href="{{ route('live') }}">
                    <div class="row webcam justify-content-center">
                        <img class="bottom" src="{{ asset('img/webcam1.png') }}" alt="LIVE">
                        <img class="top" src="{{ asset('img/webcam.png') }}" alt="LIVE">

                    </div>
                    <div class="row">
                        <p>Avvia la prova Live</p>

                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
