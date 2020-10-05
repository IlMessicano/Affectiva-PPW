@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-top:5%">
        <div class="col-md-6">
            <form method="post" action="{{ route('login') }}" class="form1">
                @csrf
                <div class="avatar-preview" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')">
                </div>
                <div style="position:relative; top:-60px;" class="form-group">
                    <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div style="position:relative; top:-60px;"class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                </div>
                <div class="form-group" style="position:relative; top:-60px;">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class="form-group" style="position:relative; top:-60px;text-align:right;">
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    </div>
                @endif
                <div class="form-group" style="position:relative; top:-30px;"><button type="submit"  class="btn btn-block" value="Accedi">Accedi</button></div>
                <div class="form-group" style="position:relative; top:-30px;"><a class="btn btn-block" href="{{ route('register') }}">Registrati</a></div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="live" onclick="">
                <div class="row webcam">
                    <img class="bottom" src="{{ asset('img/webcam1.png') }}">
                    <img class="top" src="{{ asset('img/webcam.png') }}">

                </div>
                <div class="row">
                    <p>Avvia la prova Live</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
