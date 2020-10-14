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
                    {{$content->nome}}<span class="modify"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <div class="col-12 text-center created_at">
                    Creato il:  {{date('d-m-Y', strtotime($content->dataCreazione))}}
                </div>
            </div>
            <div class="row w-100 top2_project">
                <div class="col-6 text-center">
                    <div class="row">
                        <p class="font-weight-bold">Descrizione:</p>
                    </div>
                    <div class="row">
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
