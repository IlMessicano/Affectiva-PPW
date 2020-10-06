@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="avatar-preview-reg" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')">
            </div>
                    <form class="form-reg" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="avatar-preview-reg" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')">
                        </div>
                        <div class="row mb-4"></div>
                        <h2 class="h2">Registrati ora!</h2>

                        <div class="form-group">

                            <input id="email" type="email" placeholder="Email*" class="input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                        <div class="form-group">
                                <input id="nome" type="text" placeholder="Nome*" class="input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <input id="cognome" type="text" placeholder="Cognome*" class="input form-control @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome') }}" required autocomplete="cognome" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="data" type="date" placeholder="Cognome*" class="input form-control data @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome') }}" required autocomplete="cognome" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">

                                <input id="password" type="password" placeholder="Password*" class="input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <div class="form-group">
                                <input id="password-confirm" type="password" placeholder="Conferma password*" class="input form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-block">
                                    {{ __('Registrati') }}
                                </button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection
