@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewVideo.css') }}" rel="stylesheet">
@endsection

<?php
$VideoTask= \App\Http\Controllers\TaskController::getTaskbyId($content->task);
$TaskId=$VideoTask->id;
$TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($VideoTask->progetto);
$ProjectId=$TaskProject->id;
?>

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('project', ['id' => $ProjectId ])}}">{{$TaskProject->nome}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('task', ['id' => $TaskId ])}}">{{$VideoTask->nomeTask}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$content->nomeVideo}}</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="container-fluid h-100">
        <div class="row top_video">
            <div class="row w-100 top1_video">
                <div class="col-sm-12 text-center align-content-center title">
                    {{$content->nomeVideo}}<span class="modify" data-toggle="modal" data-target="#modal_modify_video"><i class="fas fa-pencil-alt"></i></span>
                </div>
            </div>
            <div class="row w-100 top2_video">
                <div class="col-md-3 offset-md-2 text-center my-auto font-weight-bold">
                    Anteprima:
                </div>
                <div class="col-md-5 text-center">
                    <div class="anteprima mx-auto">
                            ANTEPRIMA VIDEO
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_nav w-100 text-right">
        <a class="btn" style="margin-right: 1rem">Analizza</a>
        <a class="btn" href="{{ route('export',['table'=>'video','id'=>$content->id]) }}">Export to PDF</a>
    </div>
@endsection
