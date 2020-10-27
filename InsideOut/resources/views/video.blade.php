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
    $video=\App\Http\Controllers\VideoController::getVideo($id);
?>

    @forelse($video as $video)
        <div class="row w-100">
            <div class="col-1 offset-3">
                <i class="fas fa-minus"></i>
            </div>
            <div class="col-4 video_name" id="{{$video->id}}">
                {{$video->nomeVideo}}
            </div>
            <div class="col-1 offset-2 trash_video" id="{{$video->id}}" data-toggle="modal" data-target="#modal_delete_video">
                <i class="far fa-trash-alt" style="color:#880400;"></i>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">Nessun video per questo Task</div>
    @endforelse
