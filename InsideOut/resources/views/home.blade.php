<?php
$id=Auth::id();
$project=\App\Http\Controllers\ProjectController::getUserProject($id);
$share=\App\Http\Controllers\ShareController::getShareWithMe($id);
$i=0
?>

@extends('layouts.project')

@section('head')
    <script>
        $(document).ready(function(){

            $(".p_title").click(function(){
                var id = this.id;
                $('.all_task').hide();
                $('.fa-chevron-right').removeClass('rotate');

                $('#task_of_'+id).toggle();
                $('#label_project_'+id).toggleClass('rotate');
            });
            $(".task_name").click(function(){
                $(".task_name").removeClass("font-weight-bold");
                $(this).addClass("font-weight-bold");
            });
        });
    </script>
@endsection



@section('project')

    <div class="row w-100 all_project">
        @forelse($project as $project)
            <?php $task=\App\Http\Controllers\TaskController::getTasksOfProject($project->id); $i=$project->id; ?>
            <div class="row w-100 project_n">
                <div class="col-5 offset-1 p_title" id="{{$i}}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-chevron-right" id="label_project_{{$i}}"></i>
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
            <div class="row w-100 all_task" id="task_of_{{$i}}">
            @forelse($task as $task)
                <div class="row task w-100">
                        <div class="col-1 offset-3">
                            <i class="fas fa-minus"></i>
                        </div>
                        <div class="col-4 task_name">
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
            <?php $i++ ?>
            <div class="row w-100 project_n">
                <div class="col-5 offset-1 p_title" id="{{$i}}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-chevron-right" id="label_project_{{$i}}"></i>
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

