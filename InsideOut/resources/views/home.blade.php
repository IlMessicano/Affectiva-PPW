<?php
$id=Auth::id();
$project=\App\Http\Controllers\ProjectController::getUserProject($id);
$share=\App\Http\Controllers\ShareController::getShareWithMe($id);
?>

@extends('layouts.project')

@section('head')
    <script>
        $(document).ready(function(){

            $(".p_title").click(function(){
                var id = this.id;
                $('.all_task').hide();
                $('.fa-chevron-right').removeClass('rotate');
                $(".task_name").removeClass("font-weight-bold");
                $('#task_of_'+id).show();
                $('#label_project_'+id).addClass('rotate');
                $('#content').attr('src','http://127.0.0.1:8000/project/'+id);
                $('#new_task').removeClass('disabled_task').attr('disabled',false);
                $('#new_video').addClass('disabled_video').attr('disabled',true);
                $('#progetto').attr('value', id);

            });
            $(".task_name").click(function(){
                var id = this.id;
                $(".task_name").removeClass("font-weight-bold");
                $(this).addClass("font-weight-bold");
                $('#content').attr('src','http://127.0.0.1:8000/task/'+id);
                $('#iframe').attr('value','http://127.0.0.1:8000/task/'+id);
                $('#new_video').removeClass('disabled_video').attr('disabled',false);
                $('#task').attr('value', id);
            });

            $(".trash_project").click(function(){
                var id = this.id;
                $('#delete_project').attr('value', id);
                var name = $(this).prev().text();
                $('#title_delete_progetto').text(name);
            });

            $(".trash_task").click(function(){
                var id = this.id;
                $('#delete_task').attr('value', id);
                var name = $(this).prev().text();
                $('#title_delete_task').text(name);
            });
        });
    </script>
@endsection

@section('project')

    <div class="row w-100 all_project">
        <div class="row w-100">
            <div class="col-12">
                <p class="my_project_title font-weight-bold">I miei progetti</p>
            </div>
        </div>
        @forelse($project as $project)
            <?php $task=\App\Http\Controllers\TaskController::getTasksOfProject($project->id); ?>
            <div class="row w-100 project_n">
                <div class="col-5 offset-1 p_title" id="{{$project->id}}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-chevron-right" id="label_project_{{$project->id}}"></i>
                        </div>
                        <div class="col-6" style="padding-left: 5px">
                            {{$project->nome}}
                        </div>
                    </div>
                </div>
             <div class="col-1 offset-5 trash_project" id="{{$project->id}}" data-toggle="modal" data-target="#modal_delete_project">
                    <i class="far fa-trash-alt" style="color:#880400;"></i>
                </div>
            </div>
            <div class="row w-100 all_task" id="task_of_{{$project->id}}">
            @forelse($task as $task)
                <div class="row task w-100">
                        <div class="col-1 offset-3">
                            <i class="fas fa-minus"></i>
                        </div>
                        <div class="col-4 task_name" id="{{$task->id}}">
                            {{$task->nomeTask}}
                        </div>
                        <div class="col-1 offset-2 trash_task" id="{{$task->id}}" data-toggle="modal" data-target="#modal_delete_task">
                            <i class="far fa-trash-alt" style="color:#880400;"></i>
                        </div>
                </div>
            @empty
                <div class="col-12 text-center">Nessun task creato</div>
            @endforelse
            </div>
        @empty
            <div class="col-12 text-center">Nessun progetto creato</div>
        @endforelse
    </div>
    <div class="row w-100 align-items-end project_shared">
        <div class="row w-100">
            <div class="col-12">
                <p class="shared_title font-weight-bold">Condivisi con me</p>
            </div>
        </div>
        @forelse($share as $share)
            <div class="row w-100 project_n">
                <div class="col-5 offset-1 p_title" id="{{$share->progetto}}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-chevron-right" id="label_project_{{$share->progetto}}"></i>
                        </div>
                        <div class="col-6" style="padding-left: 5px">
                            {{$share->nomeProgetto}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row w-100 all_task" id="task_of_{{$share->progetto}}">
            <?php $shareTask=\App\Http\Controllers\TaskController::getTasksOfProject($share->progetto); ?>
                @forelse($shareTask as $shareTask)
                    <div class="row task w-100">
                        <div class="col-1 offset-3">
                            <i class="fas fa-minus"></i>
                        </div>
                        <div class="col-4 task_name" id="{{$shareTask->id}}">
                            {{$shareTask->nomeTask}}
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">Nessun task creato</div>
                @endforelse
            </div>
        @empty
             <div class="col-12 text-center">Nessun progetto condiviso</div>
        @endforelse


    </div>

@endsection

@section('video')
    Video
@endsection

@section('content_center')
    @isset($iframe)
    <iframe src="{{$iframe}}" id="content">
    @endisset

    @empty($iframe)
    <iframe src="" id="content">
    @endempty
    </iframe>
@endsection

@section('modals')
    <div class="modal fade" id="modal_new_project">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Crea un nuovo progetto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('insert_project')}}">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Nome Progetto</label>
                                    <div class="col-sm-8">
                                        <input id="nome" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descrizione" class="col-sm-4 col-form-label font-weight-bold">Descrizione</label>
                                    <div class="col-sm-8">
                                        <textarea id="descrizione" type="text-area" rows="3" class="input form-control @error('nome') is-invalid @enderror" name="descrizione" value="{{ old('descrizione') }}" required autocomplete="descrizione"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="utente" id="utente" value="{{$id}}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit">Salva Progetto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_new_task">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Crea un nuovo Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('insert_task')}}">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Nome Task</label>
                                    <div class="col-sm-8">
                                        <input id="nome" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descrizione" class="col-sm-4 col-form-label font-weight-bold">Descrizione</label>
                                    <div class="col-sm-8">
                                        <textarea id="descrizione" type="text-area" rows="3" class="input form-control @error('nome') is-invalid @enderror" name="descrizione" value="{{ old('descrizione') }}" required autocomplete="descrizione"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="progetto" id="progetto" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit">Salva Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_new_video">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Aggiungi Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="#">
                            @csrf

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit">Salva Video</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_project">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Elimina progetto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('delete_project')}}">
                            @csrf
                            <div class="elimina_allert text-center">
                            Sei sicuro di voler eliminare il progetto: <br><span id="title_delete_progetto" class="font-weight-bold"></span>?
                            </div>
                            <input type="hidden" name="progetto" id="delete_project" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_task">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Elimina task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('delete_task')}}">
                            @csrf
                            <div class="elimina_allert text-center">
                            Sei sicuro di voler eliminare il task: <br><span id="title_delete_task" class="font-weight-bold"></span>?
                            </div>
                            <input type="hidden" name="task" id="delete_task" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
