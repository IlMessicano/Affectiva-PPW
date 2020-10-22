@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/video.css') }}" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $(".video_name").click(function(){
                var id = this.id;
                var content = parent.document.getElementById('content');
                $(content).attr('src','http://127.0.0.1:8000/viewVideo/'+id);
                $(".video_name").removeClass("font-weight-bold");
                $(this).addClass("font-weight-bold");
            });

            $(".trash_video").click(function(){
                var id = this.id;
                var name = $(this).prev().text();
                var modal = parent.document.getElementById('modal_delete_video');
                var title_delete_video = parent.document.getElementById('title_delete_video');
                var delete_video = parent.document.getElementById('delete_video');
                $(delete_video).attr('value', id);
                $(title_delete_video).text(name);
                $(modal).modal();
            });


        });
    </script>
@endsection

<?php
    $video=\App\Http\Controllers\VideoController::getVideo($id);
?>
@section('content')

    <div class="row w-100 all_video">
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
    </div>
@endsection
