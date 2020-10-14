@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewTask.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <?php $TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($content->progetto);$TaskId=$TaskProject->id?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('project', ['id' => $TaskId ])}}">{{$TaskProject->nome}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$content->nomeTask}}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center top_task">
            <div class="col-12 text-center align align-content-center title">
                {{$content->nomeTask}}<span class="modify"><i class="fas fa-pencil-alt"></i></span>
            </div>

            <div class="col-sm-5 text-center">
                <div class="row justify-content-center description">
                    <div class="col-sm-12">
                        <p class="font-weight-bold">Descrizione:</p>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-sm-12">
                        <p>
                            {{$content->descrizione}}
                        </p>
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
