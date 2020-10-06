@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

                    <form class="form-reg" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input class="avatar-input" type="file" id="imageUpload" accept=".png, .jpg, jpeg" name="profileimg"/>
                                <label for="imageUpload" class="fas"></label>
                            </div>
                            <div class="avatar-preview-reg">
                                <div id="imagePreview" style="background-image: url('{{asset('img/avatar/Avatar01.png')}}')"></div>
                            </div>

                        </div>

                        <div class="row mb-4"></div>
                        <h2 class="h2">Registrati ora!</h2>

                        <div class="form-group">

                            <input id="email" type="email" placeholder="Email*" class="input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                        <div class="form-group">
                                <input id="nome" type="text" placeholder="Nome*" class="input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <input id="cognome" type="text" placeholder="Cognome*" class="input form-control @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome') }}" required autocomplete="cognome">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group" id="picker" style="cursor:pointer;">
                                <input placeholder="Data di nascita*" style="cursor:pointer;  background-color:white;" readonly type="text" id="datepicker" class="input form-control data @error('data') is-invalid @enderror" name="data" value="{{ old('data') }}" required autocomplete="data">
                                <div class="input-group-append">
                                    <div class="input-group-text btn"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                </div>
                                    <script>
                                        var picker = new Pikaday({
                                            field: document.getElementById('datepicker'),
                                            trigger: document.getElementById('picker'),
                                            firstDay: 1,
                                            bound: true,
                                            i18n: {
                                                previousMonth : 'Mese precedente',
                                                nextMonth     : 'Mese successivo',
                                                months        : ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
                                                weekdays      : ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
                                                weekdaysShort : ['Dom','Lun','Mar','Mer','Gio','Ven','Sab']
                                            },
                                            format: 'DD/MM/YYYY',
                                            toString(date, format) {
                                                // you should do formatting based on the passed format,
                                                // but we will just return 'D/M/YYYY' for simplicity
                                                const day = date.getDate();
                                                const month = date.getMonth() + 1;
                                                const year = date.getFullYear();
                                                return `${day}/${month}/${year}`;
                                            },
                                            position: 'top right',
                                            yearRange: [1940, moment().get('year')],
                                            minDate: new Date(1920, 0, 1),
                                            maxDate: moment().toDate()

                                        });

                                    </script>
                            </div>

                            @error('data')
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
