@extends('layouts.user')


@section('DatiUtente')
    @foreach ($user as $user)
    @if(Auth::user()->id == $user->id)

            <div class="avatar-preview-profile" style="background-image: url('{{asset('img/avatar/avatar01.png')}}')"></div>

            <div class="container-fluid userDetails">


                {{-- NOME UTENTE --}}
                <div id="userNome">
                    <div class="row"><div class="col-9"><label><b>Nome: </b>{{ $user->nome }}</label></div>
                        <div id="editIcon"><i class="fa fa-edit" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Nome" onclick="javascript:editNome()"></i></div>
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
                            <button type="submit" class="btn btn-block">
                                SALVA
                            </button>
                        </div>
                        <button type="button" class="btn btn-block" onclick="javascript:editNomeCancel()">
                                ANNULLA
                        </button>
                    </form>
                    </div>

                {{-- COGNOME UTENTE --}}
                <div id="userCognome">
                    <div class="row"><div class="col-9"><label><b>Cognome: </b>{{ $user->cognome }}</label></div>
                        <div id="editIcon"><i class="fa fa-edit" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Cognome" onclick="javascript:editCognome()"></i></div>
                    </div>
                </div>


                {{-- FORM A COMPARSA COGNOME --}}
                <div id="formCognome">
                    <form method="POST" action="{{ route('editUser') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="column" name="column" value="cognome" readonly>
                            <label><b>Cognome: </b></label>
                            <input id="cognome" type="text" class="input form-control @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome') }}" required autocomplete="cognome">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block">
                                SALVA
                            </button>
                            <button type="button" class="btn btn-block" onclick="javascript:editCognomeCancel()">
                                ANNULLA
                            </button>
                        </div>

                </div>


                {{-- EMAIL UTENTE --}}
                <div id="userEmail">
                    <div class="row"><div class="col-9"><label><b>Email: </b>{{ $user->email }}</label></div>
                        <div id="editIcon"><i class="fa fa-edit" style="font-size:20px" data-toggle="tooltip" data-placement="right" title="Modifica Email" onclick="javascript:editEmail()"></i></div>
                    </div>
                </div>

                {{-- FORM A COMPARSA EMAIL --}}
                <div id="formEmail">
                    <form method="POST" action="{{ route('editUser') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="column" name="column" value="email" readonly>
                            <label><b>Email: </b></label>
                            <input id="data" type="text" class="input form-control @error('email') is-invalid @enderror" name="data" required autocomplete="email" >

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block">
                                SALVA
                            </button>
                        </div>
                        <button type="button" class="btn btn-block" onclick="javascript:editEmailCancel()">
                            ANNULLA
                        </button>
                    </form>
                </div>


{{-- DATA NASCITA UTENTE --}}
                <div class="row"><div class="col-9"><label><b>Data di nascita: </b><label id="dataNascita"> {{ $user->dataNascita }} </label></label></div></div>
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
    @endforeach

@endsection



@section('EliminaAccount')
    <div class="row" style="display: block; margin-top:3%">
        <h2 style="color:#ff0000; margin-left: 2%">Elimina Account</h2>
        <div style="background-color:#ff0000; margin-left: 2%; height:1px; width:60%;"></div>
        <div id="deleteConfirm">
            <button type="button" class="btn-edit" onclick="javascript:deleteCancel()">Annulla</button>
            <a class=btn-delete href="{{ route('deleteUser') }} ">Conferma</a>
        </div>

        <div id="deleteButton">
            <button type="button" class="btn-delete" onclick="javascript:deleteConfirm()">Elimina</button>
        </div>
    </div>
@endsection
