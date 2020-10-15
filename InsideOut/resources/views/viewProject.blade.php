@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewProject.css') }}" rel="stylesheet">
@endsection

<?php
$sharedWith=\App\Http\Controllers\ShareController::getSharebyProject($content->id);
?>

@section('content')
    <div class="container-fluid h-100">
        <div class="row top_project">
            <div class="row w-100 top1_project">
                <div class="col-12 text-center align-content-center title">
                    {{$content->nome}}<span class="modify" data-toggle="modal" data-target="#modal_modify_project"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <div class="col-12 text-center created_at">
                    Creato il:  {{date('d-m-Y', strtotime($content->dataCreazione))}}
                </div>
            </div>
            <div class="row w-100 top2_project">
                <div class="col-6 text-center h-100">
                    <div class="row">
                        <p class="font-weight-bold">Descrizione:</p>
                    </div>
                    <div class="row h-75" style="overflow-y:auto">
                        <p class="text-left">{{$content->descrizione}}{{$content->descrizione}}{{$content->descrizione}}{{$content->descrizione}}{{$content->descrizione}}{{$content->descrizione}}</p>
                    </div>
                </div>
                <div class="col-5 text-center h-100"  style="overflow-y: auto">
                    <div class="row align-content-center">
                        <p class="font-weight-bold w-100">Condiviso con:</p>
                    </div>
                    <div class="row w-100">
                    @forelse($sharedWith as $sharedWith)
                    <?php $email= \App\Http\Controllers\UserController::getEmailbyId($sharedWith)?>
                        <div class="col-6">
                            <i class="fas fa-minus"></i><p class="shared_name"><a href="#">{{$email}}</a></p>
                        </div>
                    @empty
                        <div class="col-12 text-center">Non hai condiviso il progetto con nessun utente</div>
                        <div class="col-12 text-center"><a class="btn" style="margin-top:0.7rem;color: #212529;">Codividi ora! <i class="fas fa-user-plus"></i></a></div>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="bottom_nav w-100 text-right">
        <a class="btn" style="margin-right: 1rem">Analizza</a>
        <a class="btn">Esporta PDF</a>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="modal_modify_project" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Modifica Progetto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('modify_project')}}" target="_top">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Nome Progetto</label>
                                    <div class="col-sm-8">
                                        <input id="nome" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $content->nome }}" required autocomplete="nome" >
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-top: 1rem">
                                    <label for="descrizione" class="col-sm-4 col-form-label font-weight-bold">Descrizione</label>
                                    <div class="col-sm-8">
                                        <textarea id="descrizione" type="text-area" rows="3" class="input form-control @error('nome') is-invalid @enderror" name="descrizione" required autocomplete="descrizione">{{ $content->descrizione }}</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="id" value="{{$content->id}}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit">Salva Modifica</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
