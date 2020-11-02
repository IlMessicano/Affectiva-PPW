@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewTask.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <?php $TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($content->progetto);$ProjectId=$TaskProject->id?>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('project', ['id' => $ProjectId ])}}">{{$TaskProject->nome}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$content->nomeTask}}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center top_task">
            <div class="col-12 text-center align align-content-center title">
                {{$content->nomeTask}}<span class="modify" data-toggle="modal" data-target="#modal_modify_task"><i class="fas fa-pencil-alt"></i></span>
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
        <a class="btn" href="{{ route('export',['table'=>'task','id'=>$content->id]) }}">Esporta PDF</a>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="modal_modify_task" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Modifica Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('modify_video')}}" target="_top">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Nome Task</label>
                                    <div class="col-sm-8">
                                        <input id="nome" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $content->nomeTask }}" required autocomplete="nome" >
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
