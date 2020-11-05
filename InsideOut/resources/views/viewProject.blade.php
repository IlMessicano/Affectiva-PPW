@extends('layouts.content')
<?php
$sharedWith=\App\Http\Controllers\ShareController::getSharebyProject($content->id);
?>

@section('head')
    <link href="{{ asset('css/ViewProject.css') }}" rel="stylesheet">

    <script>
        $(document).ready(function(){
            $('#modal_modify_project').on('shown.bs.modal', function() {
                $('#nome').focus();
            });

            $('#modal_share_project').on('shown.bs.modal', function() {
                $('#share_email').focus()
            });

            $(".trash").click(function(){
                var id = this.id;
                $('#delete_share').attr('value', id);
                var name = $(this).prev().text();
                $('#title_delete_share').text(name);
            });

            $('.btn_analysis').click(function(){
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).show();
                var id= this.id;
                $(this).hide();
                $('#loading_'+id).show();
                $('#all').attr('disabled',true).css('cursor','not-allowed');
                $('#dismiss_analysis').attr('disabled',true).css('cursor','not-allowed');
                $('.btn_analysis').attr('disabled',true).css('cursor','not-allowed');
            });

            $('#all').click(function(){
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).show();
                $('.btn_analysis').hide();
                $('.loading').show();
                $('#all').attr('disabled',true).css('cursor','not-allowed');
                $('#dismiss_analysis').attr('disabled',true).css('cursor','not-allowed');
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

@section('content')

    <div class="container-fluid h-100">
        <div class="row top_project">
            <div class="row w-100 top1_project">
                <div class="col-12 text-center align-content-center title">
                    {{$content->nome}}
                    @if(Auth::id() == $content->utente)
                        <span class="modify" data-toggle="modal" data-target="#modal_modify_project"><i class="fas fa-pencil-alt"></i></span>
                    @endif
                </div>
                <div class="col-12 text-center created_at">
                    Creato il:  {{date('d-m-Y', strtotime($content->dataCreazione))}}
                </div>
            </div>
            <div class="row w-100 top2_project">
                <div class="col-6 text-center h-100">
                    <div class="row">
                        <p class="font-weight-bold">Descrizione:</p>
                    </div>
                    <div class="row h-75" style="overflow-y:auto">
                        <p class="text-left">{{$content->descrizione}}</p>
                    </div>
                </div>
                <div class="col-6 text-center h-100"  style="overflow-y: auto">
                @if(Auth::id() == $content->utente)
                    <div class="row align-content-center">
                        <p class="font-weight-bold w-100">Condiviso con:</p>
                    </div>
                    <div class="row w-100">
                        @forelse($sharedWith as $sharedWith)
                            <?php $email = \App\Http\Controllers\UserController::getEmailbyId($sharedWith->collaboratore)?>
                            <div class="col-6">
                                <div class="row w-100">
                                    <div class="col-1">
                                        <i class="fas fa-minus"></i>
                                    </div>
                                    <div class="col-8">
                                        <p class="shared_name"><a href="{{route('profile',['id'=>$sharedWith->collaboratore])}}" target="_parent">{{$email->email}}</a></p>
                                    </div>
                                    <div class="trash" id="{{$sharedWith->collaboratore}}" data-toggle="modal" data-target="#modal_delete_share">
                                        <i class="far fa-trash-alt" style="color:#880400;"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                                <div class="col-12 text-center">Non hai condiviso il progetto con nessun utente</div>
                        @endforelse
                        <div class="row w-100">
                            <div class="col-12 text-center"><button class="btn" style="margin-top:0.7rem;color: #212529;" data-toggle="modal" data-target="#modal_share_project">Codividi ora! <i class="fas fa-user-plus"></i></button></div>
                        </div>
                    </div>
                    @error('share')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @else
                        <?php $owner = \App\Http\Controllers\UserController::getEmailbyId($content->utente)?>
                        <div class="row">
                            <p class="w-100"><span class="font-weight-bold" >Proprietario: </span><a href="{{route('profile',['id'=>$content->utente])}}" target="_parent">{{$owner->email}}</a></p>
                        </div>
                            <div class="row">
                                <p class="w-100"><span class="font-weight-bold">Collaboratori:</span></p>
                            </div>
                            <div class="row w-100">
                                @forelse($sharedWith as $sharedWith)
                                    <?php $email = \App\Http\Controllers\UserController::getEmailbyId($sharedWith->collaboratore)?>
                                    <div class="col-6">
                                        <div class="row w-100">
                                            <div class="col-1">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                            @if($email->email != Auth::user()->email)
                                            <div class="col-8">
                                                <p class="shared_name"><a href="#">{{$email->email}}</a></p>
                                            </div>
                                            @else
                                            <div class="col-2">
                                                <p class="shared_name">Tu</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">Non hai condiviso il progetto con nessun utente</div>
                                @endforelse
                            </div>
                    @endif
                </div>
            </div>
        </div>



        <div class="bottom_nav w-100 text-right">
            <a class="btn" style="margin-right: 1rem"  data-toggle="modal" data-target="#modal_analysis">Analizza</a>
            <a class="btn" href="{{ route('export',['table'=>'progetto','id'=>$content->id]) }}">Esporta PDF</a>
        </div>
    </div>

@endsection

@section('modals')
    <div class="modal fade" id="modal_modify_project" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Modifica Progetto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('modify_project')}}" target="_top">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Nome Progetto</label>
                                    <div class="col-sm-8">
                                        <input autofocus id="nome" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $content->nome }}" required autocomplete="nome" >
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

    <div class="modal fade" id="modal_share_project" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Condividi il tuo progetto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('insert_share')}}">
                            @csrf
                            <div class="modal_form">
                                <div class="form-group row" style="margin-bottom:0.7rem">
                                    <label for="nome" class="col-sm-4 col-form-label font-weight-bold">Email</label>
                                    <div class="col-sm-8">
                                        <input autofocus id="share_email" type="text" class="input form-control @error('nome') is-invalid @enderror" name="share_email" value="{{ old('share_email') }}" required>
                                    </div>
                                </div>
                                <input type="hidden" name="progetto" id="progetto" value="{{$content->id}}">
                                <input type="hidden" name="proprietario" id="proprietario" value="{{$content->utente}}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button class="btn" type="submit">Aggiungi condivisione</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_delete_share" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Elimina condivisione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid h-100">
                        <form method="post" action="{{route('delete_share')}}">
                            @csrf
                            <div class="elimina_allert_share text-center">
                                Sei sicuro di voler eliminare la condivisione con: <br><span id="title_delete_share" class="font-weight-bold"></span>?
                            </div>
                            <input type="hidden" name="id_share" id="delete_share" value="">
                            <input type="hidden" name="id_project" value="{{$content->id}}">
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

    <div class="modal fade" id="modal_analysis" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Video da analizzare
                </div>
                <div class="modal-body" style="height: 20rem;overflow-y: auto">
                    <div class="container">
                        <?php $tot=0;$i=0;
                        $task=\App\Http\Controllers\TaskController::getTasksOfProject($content->id); ?>
                        @forelse($task as $task)
                            <?php $videos=\App\Http\Controllers\VideoController::getVideo($task->id);
                            $tot += count($videos);
                            ?>
                            <div class="row w-100 task_title">
                                <div class="col-5 offset-1 font-weight-bold">
                                    {{$task->nomeTask}}
                                </div>
                            </div>
                            <div class="container-fluid analysis_contain">
                                @forelse($videos as $video)
                                    <div class="row w-100 analysis">
                                        <div class="col-7 offset-md-2 my-auto">
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
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    @if($i==$tot)
                        <script> $(document).ready(function(){$('#all').attr('disabled','true').css('cursor','not-allowed');});</script>
                    @else
                        <script> $(document).ready(function(){$('#btn_all').attr('disabled','true').css('cursor','not-allowed');});</script>
                    @endif
                    @if($tot>0)
                        <button id="all" class="btn">Analizza tutto</button>
                        <button class="btn" id="btn_all">Analizza Progetto</button>
                    @endif
                    <button type="button" id="dismiss_analysis" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
