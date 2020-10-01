@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Login</h2>
            <form method="post" action=ction="{{ route('login') }}" class="form1">
                @csrf
                <div class="avatar-preview" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')">
                </div>
                <div style="position:relative; top:-30px;" class="form-group">
                    <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div style="position:relative; top:-20px;"class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                </div>
                <div class="form-group" style="position:relative; top:-20px;">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class="form-group" style="position:relative; top:-20px;text-align:right;">
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    </div>
                @endif
                <div class="form-group"><input type="submit" class="btn btn-block" value="Accedi"></div>
                <div class="form-group"><button class="btn btn-block" onclick="{{ route('register') }}">{{ __('Registrati') }}</button></div>
            </form>
        </div>
        <div class="col-md-6">
            <h2>Live</h2>
            <div class="live">
                <div class="row webcam">
                </div>
                <div class="row">
                    <p>Avvia la prova Live</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
