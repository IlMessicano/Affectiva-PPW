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
                $('#new_task').removeClass('disabled');
                $('#new_video').addClass('disabled');
            });
            $(".task_name").click(function(){
                var id = this.id;
                $(".task_name").removeClass("font-weight-bold");
                $(this).addClass("font-weight-bold");
                $('#content').attr('src','http://127.0.0.1:8000/task/'+id);
                $('#new_video').removeClass('disabled');
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
                <div class="col-1 offset-5 trash">
                    <i class="far fa-trash-alt" style="color:#c00000;"></i>
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
                        <div class="col-1 offset-2 trash">
                            <i class="far fa-trash-alt" style="color:#c00000;"></i>
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
                <div class="col-1 offset-5 trash">
                    <i class="far fa-trash-alt" style="color:#c00000;"></i>
                </div>
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
    <iframe src="" id="content">
    </iframe>
@endsection
