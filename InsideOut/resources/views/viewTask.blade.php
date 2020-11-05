@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewTask.css') }}" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Load Affectiva API -->
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2/affdex.js"></script>

    {{--    Script Analysis--}}
    <script type="text/javascript" src="{{asset('js/scriptAnalisi.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.btn_analysis').click(function(){
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).show();
                var id= this.id;
                $(this).hide();
                $('#loading_'+id).show();
                $('#all').attr('disabled',true).css('cursor','not-allowed');
                // $('#dismiss_analysis').attr('disabled',true).css('cursor','not-allowed');
                $('.btn_analysis').attr('disabled',true).css('cursor','not-allowed');
            });

            $('#all').click(function(){
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).show();
                $('.btn_analysis').hide();
                $('.loading').show();
                $('#all').attr('disabled',true).css('cursor','not-allowed');
                // $('#dismiss_analysis').attr('disabled',true).css('cursor','not-allowed');
            });

            $('#dismiss_analysis').click(function(){
                $('.btn_analysis').attr('disabled',false).css('cursor','pointer');
                $('#all').attr('disabled',false).css('cursor','pointer');
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).hide();
            });

        });

    </script>
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
        <div class="bottom_nav w-100 text-right">
            <button class="btn" style="margin-right: 1rem" data-toggle="modal" data-target="#modal_analysis">Analizza</button>
            <a class="btn" href="{{ route('export',['table'=>'task','id'=>$content->id]) }}">Esporta PDF</a>
        </div>
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

    <div class="modal fade" id="modal_analysis" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Video da analizzare
                </div>
                <div class="modal-body" style="height: 18rem;overflow-y: auto">
                    <div class="container">
                        <?php $videos=\App\Http\Controllers\VideoController::getVideo($content->id);
                        $i=0;
                        ?>
                        @if(count($videos)>0)
                                <div class="row w-100 text-center" style="margin-top: 1rem">
                                    <div class="col-4 offset-md-7 text-center">
                                        <button id="all" class="btn">Analizza tutto</button>
                                    </div>
                                </div>
                        @endif
                        <div class="container-fluid analysis_contain">
                        @forelse($videos as $video)
                            <div class="row w-100 analysis">
                                <div class="col-7 offset-md-1 my-auto">
                                    {{$video->nomeVideo}}
                                </div>
                                <div class="col-2 my-auto">
                                    @if($video->risultatiAnalisi == null)

                                        <button class="btn btn_analysis" id="{{$video->id}}">Analizza</button>
                                        <div id="loading_{{$video->id}}" class="loading" style="display:none">
                                            <div class="loader mx-auto"></div>
                                            <p class="percent text-center mx-auto small">0%</p>
                                        </div>
                                    @else
                                        <?php $i++;?>
                                        <i class="far fa-check-circle text-success fa-2x"></i>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="row w-100 analysis">
                                <div class="col-12 text-center">
                                    Nessun video per questo Task
                                </div>
                            </div>
                        @endforelse
                        </div>
                        @if($i==count($videos))
                                <script>$('#all').attr('disabled','true').css('cursor','not-allowed')</script>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="dismiss_analysis" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
