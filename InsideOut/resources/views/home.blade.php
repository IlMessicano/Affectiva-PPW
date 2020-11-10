<?php
$id=Auth::id();
$project=\App\Http\Controllers\ProjectController::getUserProject($id);
$share=\App\Http\Controllers\ShareController::getShareWithMe($id);
?>

@extends('layouts.project')

@section('head')
    <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
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
                $('#video').attr('src','about::blank');
                $('#task_video').text(' ');
                $('#videoOfTask').html(' ');

            });

            $(".task_name").click(function(){
                var id = this.id;
                $(".task_name").removeClass("font-weight-bold");
                $(this).addClass("font-weight-bold");
                $('#content').attr('src','http://127.0.0.1:8000/task/'+id);
                $('#new_video').removeClass('disabled_video').attr('disabled',false);
                $('#task').attr('value', id);
                $('#delete_video_task').attr('value', id);
                var name = $(this).text();
                $('#task_video').text(name);
                showVideo(id);
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

            $('#nomeVideo').on('change', function(){
                var lenght = this.files.length;
                console.log(lenght);
                var fileName='-- '+this.files.item(0).name+' -- ';
                if(lenght>1){
                    for (var i = 1; i <= length; ++i){
                        fileName+=this.files.item(i).name+' -- ';
                    }
                    $(this).next('.custom-file-label').html(fileName);
                }
                else{
                    $(this).next('.custom-file-label').html(fileName);
                }
            });

            $('#upload_video').on('submit', function(e){
                $('.progress').show();
                $('.block_body').show();
                e.preventDefault();
                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $(".progress").html('<div class="progress-bar" style="width:'+percentComplete + '%">'+percentComplete.toFixed(0) + '%</div>');
                            }
                        }, false);
                        return xhr;
                    },
                    url: '{{url('/save-video-upload')}}',
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(res) {
                        $('#content').attr('src','http://127.0.0.1:8000/viewVideo/'+res);
                        $('.block_body').hide();
                        $('#modal_new_video').modal('hide');
                        var task = $("#task").val();
                        showVideo(task);
                        $('.progress').hide();
                        $(".custom-file-label").html("Seleziona Video...");
                    },
                    error: function (jqXHR, exception) {
                    console.log(jqXHR);
                    $("#modal_new_video").modal('hide');
                    $("#modal_error_msg").html(JSON.stringify(jqXHR.responseJSON.errors,["nomeVideo.0"]).replace("{\"nomeVideo.0\":[\"","").replace("\"]}",""));
                    // $("#modal_error_msg").html('Impossibile analizzare il file. Errore: '+jqXHR.status);
                    $("#modal_error").modal();
                }
                });
            });

            $('#delete_video_Form').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{route('delete_video')}}',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function() {
                        var task = $("#task").val();
                        $('#content').attr('src','http://127.0.0.1:8000/task/'+task);
                        $('#modal_delete_video').modal('hide');
                        showVideo(task);
                    },
                });
            });

        });

        function showVideo(id) {
            $.ajax({
                url:'http://127.0.0.1:8000/video/'+id,
                success:function(result){
                    $('#videoOfTask').html(result);
                }
            });
        }

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
                <div class="col-7 offset-1 p_title" id="{{$project->id}}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-chevron-right" id="label_project_{{$project->id}}"></i>
                        </div>
                        <div class="col-6" style="padding-left: 5px">
                            {{$project->nome}}
                        </div>
                    </div>
                </div>
             <div class="col-1 offset-3 trash_project" id="{{$project->id}}" data-toggle="modal" data-target="#modal_delete_project">
                    <i class="far fa-trash-alt" style="color:#880400;"></i>
                </div>
            </div>
            <div class="row w-100 all_task" id="task_of_{{$project->id}}">
            @forelse($task as $task)
                <div class="row task w-100">
                        <div class="col-1 offset-3">
                            <i class="fas fa-minus"></i>
                        </div>
                        <div class="col-6 task_name" id="{{$task->id}}">
                            {{$task->nomeTask}}
                        </div>
                        <div class="col-1 trash_task" id="{{$task->id}}" data-toggle="modal" data-target="#modal_delete_task">
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

    <?php
    $video=\App\Http\Controllers\VideoController::getVideo($id);
    ?>

    <div class="row w-100 h-100 all_video h-auto">
        <div class="row w-100">
            <div class="col-12">
                <p class="my_video_title font-weight-bold">Video del task: <span id="task_video"></span></p>
            </div>
        </div>
        <div class="row w-100" id="videoOfTask">

        </div>
    </div>
@endsection

@section('content_center')
    @isset($iframe)
    <iframe title="Visualizzazione" src="{{$iframe}}" id="content">
    @endisset

    @empty($iframe)
    <iframe title="Visualizzazione" src="" id="content">
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

    <div class="modal fade" id="modal_new_video" data-backdrop="static">
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
                        <form method="post" id="upload_video" enctype="multipart/form-data">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="nomeVideo" required name="nomeVideo[]" multiple="multiple" placeholder="Seleziona Video...">
                                        <label class="custom-file-label" for="nomeVideo" id="selectList">Scegli video</label>
                                    </div>
                                    <input type="hidden" name="task" id="task" value="">
                                    <div class="progress">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <p class="small text-white font-weight-bold">I VIDEO DEVONO ESSERE IN FORMATO .mp4</p>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit" id="submitVideo">Salva Video</button>
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

    <div class="modal fade" id="modal_delete_video" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Elimina video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" id="delete_video_Form">
                            @csrf
                            <div class="elimina_allert text-center">
                            Sei sicuro di voler eliminare il Video: <br><span id="title_delete_video" class="font-weight-bold"></span>?
                            </div>
                            <input type="hidden" name="video" id="delete_video" value="">
                            <input type="hidden" id="delete_video_task" name="task" value="">
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

    <div class="modal fade" id="modal_error" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">ERRORE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <p id="modal_error_msg" class="mt-5 mb-5 text-center w-100 text-danger">Erorre caricamento video</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-danger">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
