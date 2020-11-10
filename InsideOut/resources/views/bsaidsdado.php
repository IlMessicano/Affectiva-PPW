@extends('layouts.user')


@section('DatiUtente')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>





    @if(Auth::user()->id == $user->id)

            <div class="container-fluid userDetails">

                {{-- AVATAR UTENTE INSERIRE MODIFICA --}}
              {{--  <div class="avatar-preview-profile" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')"></div> --}}

            <div id="userAvatar">
                <script>
                    function select(img) {
                        var ProfileImg = document.getElementById("imageUpload");
                        ProfileImg.value = img.src;
                        console.log(ProfileImg.value);
                        $('#imagePreview').attr('style', 'background-image: url('+ProfileImg.value+')');
                    }

                    function unset(){
                        var ProfileImg = document.getElementById("imageUpload");
                        ProfileImg.value = '{{asset('img/avatar/Avatar01.png')}}';
                        console.log(ProfileImg.value);
                    }

                </script>
                <form method="POST" action="{{ route('editUser') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="column" name="column" value="imgProfilo" readonly>
                    </div>
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <div id="editIcon" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-alt" style="font-size:30px; position:absolute; top: 0;" data-toggle="tooltip" data-placement="right" title="Modifica Avatar" onclick="javascript:editAvatar()"></i></div>
                        </div>
                        <div class="avatar-preview-reg">
                            <div id="imagePreview" style="background-image: url('{{$user->imgProfilo}}')"></div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Scegli il tuo avatar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" hidden id="imageUpload" name="data" value="{{$user->imgProfilo}}">
                                    <div class="row">
                                        <div class="col-3 center">
                                            <img src="{{asset('img/avatar/Avatar01.png')}}" alt="Avatar01" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar02.png')}}" alt="Avatar02" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar03.png')}}" alt="Avatar03" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar04.png')}}" alt="Avatar04" onclick="select(this)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar05.png')}}" alt="Avatar05" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar06.png')}}" alt="Avatar06" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar07.png')}}" alt="Avatar07" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar08.png')}}" alt="Avatar08" onclick="select(this)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar09.png')}}" alt="Avatar09" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar10.png')}}" alt="Avatar10" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar11.png')}}" alt="Avatar11" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar12.png')}}" alt="Avatar12" onclick="select(this)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar13.png')}}" alt="Avatar13" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar14.png')}}" alt="Avatar14" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar15.png')}}" alt="Avatar15" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar16.png')}}" alt="Avatar16" onclick="select(this)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar17.png')}}" alt="Avatar17" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar18.png')}}" alt="Avatar18" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar19.png')}}" alt="Avatar19" onclick="select(this)">
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset('img/avatar/Avatar20.png')}}" alt="Avatar20" onclick="select(this)">
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
                            </div>
                        </div>
                    </div>
                    <div id="formAvatar">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success">
                                SALVA
                            </button>
                        </div>
                        <a type="button" class="btn btn-block btn-danger" href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                            ANNULLA
                        </a>
                    </div>
                </form>
            </div>


                {{-- NOME UTENTE --}}
                <div id="userNome">
                    <div class="row"><div class="col-9"><label><b>Nome: </b>{{ $user->nome }}</label></div>
                        <div id="editIcon"><i class="fas fa-pencil-alt" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Nome" onclick="javascript:editNome()"></i></div>
                    </div>
                </div>

                {{-- FORM A COMPARSA NOME --}}
                <div id="formNome">
                    <form method="POST" action="{{ route('editUser') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="column" name="column" value="nome" readonly>
                            <label><b>Nome: </b></label>
                            <input id="data" type="text" class="input form-control @error('name') is-invalid @enderror" name="data" required autocomplete="nome" >

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success">
                                SALVA
                            </button>
                        </div>
                        <button type="button" class="btn btn-block btn-danger" onclick="javascript:editNomeCancel()">
                                ANNULLA
                        </button>
                    </form>
                    </div>

                {{-- COGNOME UTENTE --}}
                <div id="userCognome">
                    <div class="row"><div class="col-9"><label><b>Cognome: </b>{{ $user->cognome }}</label></div>
                        <div id="editIcon"><i class="fas fa-pencil-alt" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Cognome" onclick="javascript:editCognome()"></i></div>
                    </div>
                </div>


                {{-- FORM A COMPARSA COGNOME --}}
                <div id="formCognome">
                    <form method="POST" action="{{ route('editUser') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="column" name="column" value="cognome" readonly>
                            <label><b>Cognome: </b></label>
                            <input id="cognome" type="text" class="input form-control @error('cognome') is-invalid @enderror" name="data" value="{{ old('cognome') }}" required autocomplete="cognome">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success">
                                SALVA
                            </button>
                        </div>
                            <button type="button" class="btn btn-block btn-danger" onclick="javascript:editCognomeCancel()">
                                ANNULLA
                            </button>
                    </form>
                </div>


                {{-- EMAIL UTENTE --}}
                <div id="userEmail">
                    <div class="row"><div class="col-9"><label><b>Email: </b>{{ $user->email }}</label></div></div>
                </div>


{{-- DATA NASCITA UTENTE --}}
                <div id="userDataNascita">
                    <div class="row"><div class="col-9"><label><b>Data di nascita: </b>{{ $user->dataNascita }}</label></div>
                        <div id="editIcon"><i class="fas fa-pencil-alt" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Data Nascita" onclick="javascript:editDataNascita()"></i></div>
                    </div>
                </div>

                {{-- FORM A COMPARSA DATA NASCITA --}}
                <div id="formDataNascita">
                    <form method="POST" action="{{ route('editUser') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="column" name="column" value="dataNascita" readonly>
                            <label><b>Data di nascita: </b></label>

                        {{--   INSERIRE INPUT DATA DI NASCITA --}}
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
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success">
                                SALVA
                            </button>
                        </div>
                    </form>
                        <button type="button" class="btn btn-block btn-danger" onclick="javascript:editDataNascitaCancel()">
                            ANNULLA
                        </button>
                </div>

            {{-- PASSWORD UTENTE --}}
            <div id="userPassword">
                <div class="row"><div class="col-9"><label><b>Password: </b>********</label></div>
                    <div id="editIcon"><i class="fas fa-pencil-alt" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Password" onclick="javascript:editPassword()"></i></div>
                </div>
            </div>
            @error('password_updated')
                <span class="text-success" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            @error('password_not_updated')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            {{-- FORM A COMPARSA PASSWORD --}}
            <div id="formPassword">
                <form method="POST" action="{{ route('verify.password') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" id="column" name="column" value="password" readonly>
                        <label><b>Vecchia password: </b></label>
                        <input id="password" required type="password" class="form-control" name="current_password" autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><b>Nuova password: </b></label>
                        <input required id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                <div class="form-group">
                        <label><b>Conferma password: </b></label>
                    <input required id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                     @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">
                            SALVA
                        </button>
                    </div>
                    <button type="button" class="btn btn-block btn-danger" onclick="javascript:editPasswordCancel()">
                        ANNULLA
                    </button>
                </form>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            </div>

        @else
            <div class="avatar-preview-profile" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')"></div>
        <div class="container-fluid userDetails">
            <div class="row"><div class="col-9"><label><b>Nome:</b> {{ $user->nome }} </label></div></div>
            <div class="row"><div class="col-9"><label><b>Cognome:</b> {{ $user->cognome }} </label></div></div>
            <div class="row"><div class="col-9"><label><b>E-mail:</b> {{ $user->email }} </label></div></div>
            <div class="row"><div class="col-9"><label><b>Data di nascita:</b> {{ $user->dataNascita }} </label></div></div>
        </div>
    @endif

@endsection



@section('EliminaAccount')
    <div class="row eliminaAccount" style="display: block; margin-top:3%">
        <h2 style="color:#ff0000; margin-left: 2%">Elimina Account</h2>
        <div style="background-color:#ff0000; margin-left: 2%; height:1px; width:60%;"></div>
        <div id="deleteConfirm">
            <button type="button" class="btn-edit" onclick="javascript:deleteCancel()"><b>Annulla</b></button>
            <a class=btn-delete href="{{ route('deleteUser') }} "><b>Conferma</b></a>
        </div>

        <div id="deleteButton">
            <button type="button" class="btn-delete" onclick="javascript:deleteConfirm()"><b>Elimina</b></button>
        </div>
    </div>
@endsection
