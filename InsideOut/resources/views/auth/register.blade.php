@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/login_register.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <script>
                function select(img) {
                    var ProfileImg = document.getElementById("imgProfilo");
                    ProfileImg.value = img.src;
                    console.log(ProfileImg.value);
                    $('#imagePreview').attr('style', 'background-image: url('+ProfileImg.value+')');
                }

                function unset(){
                    var ProfileImg = document.getElementById("imgProfilo");
                    ProfileImg.value = '{{asset('img/avatar/Avatar01.png')}}';
                    console.log(ProfileImg.value);
                }

            </script>
                    <form class="form-reg" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="avatar-upload">
                            <div class="avatar-edit @error('imgProfilo') is-invalid @enderror">
                                <span data-toggle="modal" data-target="#exampleModal" class="fas"></span>
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
                                <input id="nome" type="text" placeholder="Nome*" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <input id="cognome" type="text" placeholder="Cognome*" class="input form-control @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome') }}" required autocomplete="cognome">

                            @error('cognome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group" id="picker" style="cursor:pointer;">

                                <input placeholder="Data di nascita*" style="cursor:pointer;  background-color:white;" readonly type="text" id="dataNascita" class="input form-control data @error('dataNascita') is-invalid @enderror" name="dataNascita" value="{{ old('dataNascita') }}" required autocomplete="dataNascita">

                                <div class="input-group-append">
                                    <div class="input-group-text btn"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                </div>
                                    <script>
                                        var picker = new Pikaday({
                                            field: document.getElementById('dataNascita'),
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

                            @error('dataNascita')
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

                        <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Scegli il tuo avatar</h5>
                                        <button type="button" class="close" onclick="unset()" data-dismiss="modal" aria-label="Close" >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" hidden id="imgProfilo" value="{{asset('img/avatar/Avatar01.png')}}" name="imgProfilo">
                                        <div class="row">
                                            <div class="col-3 center">
                                                <img src="{{asset('img/avatar/Avatar01.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar02.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar03.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar04.png')}}" onclick="select(this)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar05.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar06.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar07.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar08.png')}}" onclick="select(this)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar09.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar10.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar11.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar12.png')}}" onclick="select(this)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar13.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar14.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar15.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar16.png')}}" onclick="select(this)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar17.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar18.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar19.png')}}" onclick="select(this)">
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('img/avatar/Avatar20.png')}}" onclick="select(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $(".col-3").click(function () {

                                                $(".col-3").removeClass('active');
                                                $(this).addClass('active');

                                            });
                                        });
                                    </script>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="unset()">Close</button>
                                        <button type="button" class="btn" data-dismiss="modal">Save changes</button>
                                    </div>
                                </div>
                            </div>
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
