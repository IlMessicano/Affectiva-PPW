<script>

    $(".video_name").click(function(){
        var id = this.id;
        $("#content").attr('src','http://127.0.0.1:8000/viewVideo/'+id);
        $(".video_name").removeClass("font-weight-bold");
        $(this).addClass("font-weight-bold");
    });

    $(".trash_video").click(function(){
        var id = this.id;
        var name = $(this).prev().text();
        $('#delete_video').attr('value', id);
        $('#title_delete_video').text(name);
        $('#modal_delete_video').modal();

    });


</script>


<?php
    $check=\App\Http\Controllers\VideoController::check($id);

    $video =\App\Http\Controllers\VideoController::getVideo($id);

    if($check==1){
        $task = \App\Http\Controllers\TaskController::getTaskbyId($video[0]->task);
        $project = \App\Http\Controllers\ProjectController::getProjectbyId($task->progetto);
        $proprietario = $project->utente;
    }
?>

    @forelse($video as $video)
        <div class="row w-100">
            <div class="col-1 offset-3">
                <i class="fas fa-minus"></i>
            </div>
            <div class="col-6 video_name" id="{{$video->id}}">
                {{$video->nomeVideo}}
            </div>
            @if(Auth::user()->id == $proprietario)
            <div class="col-1 trash_video" id="{{$video->id}}" data-toggle="modal" data-target="#modal_delete_video">
                <i class="far fa-trash-alt" style="color:#880400;"></i>
            </div>
            @endif
        </div>
    @empty
        <div class="col-12 text-center">Nessun video per questo Task</div>
    @endforelse
