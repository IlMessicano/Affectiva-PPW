<?php
$id=Auth::id();
$project=\App\Http\Controllers\ProjectController::getUserProject($id);
$i=0
?>

@extends('layouts.project')

@section('head')
    <script>
        var clicked = false;
        $(document).ready(function(){
            $(".p_title").click(function(){
                var id = this.id;
                $('#task_of_'+id).toggle();

                var deg = clicked ? 0 : 90;
                //when it is not clicked, rotates 180 deg, else rotates 0 deg.
                $('#label_project_'+id).css({
                    "transform":"rotate("+deg+"deg)"
                });
                clicked = !clicked;
            });

        });
    </script>
@endsection



@section('project')

    <div class="row w-100 all_project">
        @forelse($project as $project)
            <?php $task=\App\Http\Controllers\TaskController::getTasksOfProject($project->id); $i++; ?>
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
                <div class="row task w-100 h-25">
                        <div class="col-1 offset-3">
                            <i class="fas fa-minus"></i>
                        </div>
                        <div class="col-4">
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

@endsection

@section('video')
    Video
@endsection

