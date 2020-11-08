@extends('layouts.content')
<?php
$sharedWith=\App\Http\Controllers\ShareController::getSharebyProject($content->id);
$idAnalyze = []; $all_video =[];
?>

@section('head')
    <link href="{{ asset('css/ViewProject.css') }}" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Load Affectiva API -->
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2/affdex.js"></script>

    {{--    Script Analysis--}}
    <script type="text/javascript" src="{{asset('js/scriptAnalisiProject.js')}}"></script>

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
                // $('#dismiss_analysis').attr('disabled',true).css('cursor','not-allowed');
                $('.btn_analysis').attr('disabled',true).css('cursor','not-allowed');
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

    @if($content->risultatiAnalisi == null)
    <div class="row w-100" hidden id="Grafici_A" style="padding-left:2rem">
    @else
    <div class="row w-100" id="Grafici_A" style="padding-left:2rem">
    @endif
        <div class="row w-100">
            <div class="col-12 text-center">
                <p class="font-weight-bold pt-2">Seleziona le emozioni che desideri visualizzare e clicca su: Disegna Grafico</p>
                <form id="sw" action="" method="post">
                    <input class="sw" name="sw[]" type = "checkbox" value='0'> Gioia
                    <input class="sw" name="sw[]" type = "checkbox" value='1'> Tristezza
                    <input class="sw" name="sw[]" type = "checkbox" value='2'> Disgusto
                    <input class="sw" name="sw[]" type = "checkbox" value='3'> Disprezzo
                    <input class="sw" name="sw[]" type = "checkbox" value='4'> Rabbia
                    <input class="sw" name="sw[]" type = "checkbox" value='5'> Paura
                    <input class="sw" name="sw[]" type = "checkbox" value='6'> Sorpresa
                </form>
            </div>
        </div>
        <div class="row w-100 mt-3">
            <div class="col-2 offset-md-3">
                <button class="btn" id="drow">Disegna Grafico</button>
            </div>
            <div class="col-2 offset-md-2">
                <button class="btn" id="showAll">Mostra Tutte</button>
            </div>
        </div>
        <div class="row w-100" style="margin-top:1.5rem">
            <div class="col-6 h-100">
                <div id="columnchart_values" style="display:block; float:left;"></div>         <!-------------DIV BarChart----------------->
            </div>
            <div class="col-6 h-100">
                <div id="piechart" style="display:block; float:right;"></div>        <!-------------DIV PieChart----------------->
            </div>
        </div>
        <div class="row w-100 mt-4">
            <div class="col-3 text-center">
                <p class="text-primary">Valore dell'Engagement:  <span class="font-weight-bold" id="engagement"></span></p>
            </div>
        </div>
    </div>

    @if($content->risultatiAnalisi == null)
    <div class="bottom_nav w-100 text-right"style="position:absolute;bottom:4%">
        <button class="btn" id="analizza" style="margin-right: 1rem;" data-toggle="modal" data-target="#modal_analysis_project" >Analizza</button>
{{--        <a class="btn" href="{{ route('export',['table'=>'video','id'=>$content->id]) }}">Esporta PDF</a>--}}
    </div>
    @else
    <div class="bottom_nav w-100 text-right">
{{--        <button class="btn" style="margin-right: 1rem" disabled>Analizza</button>--}}
        <a class="btn" href="{{ route('export',['table'=>'video','id'=>$content->id]) }}">Esporta PDF</a>
    </div>
    @endif
            {{--                <button class="btn" onclick="mediaa({{$content->risultatiAnalisi}})"></button>--}}

    </div>

    @if($content->risultatiAnalisi != null)
        <script type="text/javascript">
            var json = '{{$content->risultatiAnalisi}}';
            var obj = JSON.parse(json.replace(/&quot;/g,'"'));
            function log(node_name, msg) {
                $(node_name).append("<span>" + msg + "</span><br />")
            }

            google.charts.load("current", {packages:['corechart']});
            google.charts.setOnLoadCallback(drawColumnChart);
            function drawColumnChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Percentuale", { role: "style" } ],
                    ["Gioia", (Number(obj.joy)), "yellow"],
                    ["Tristezza", (Number(obj.sadness)), "brown"],
                    ["Disgusto", (Number(obj.disgust)), "green"],
                    ["Disprezzo", (Number(obj.contempt)), "grey"],
                    ["Rabbia", (Number(obj.anger)), "red"],
                    ["Paura", (Number(obj.fear)), "orange"],
                    ["Sorpresa", (Number(obj.surprise)), "gold"],
                ]);
                $('#engagement').html(Number(obj.engagement).toFixed(3));

                var view = new google.visualization.DataView(data);

                var options = {
                    title: "BarChart della media delle emozioni",
                    width: 500,
                    height: 200,
                    bar: {groupWidth: "50%"},
                    legend: { position: "none" },
                };
                var chartCol = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));

                $("#showAll").click(function (){
                    view.setRows([0,1,2,3,4,5,6]);
                    chartCol.draw(view, options);
                });

                $("#drow").click(function (){
                    var selected=[];
                    $(".sw:checkbox:checked").each(function () {
                        selected.push($(this).attr('value'));
                    });
                    var stack = new Array();
                    for(var i=0; i<selected.length; i++){
                        stack[i] = Number(selected[i]);
                    }
                    view.setRows(stack);
                    chartCol.draw(view, options);
                });
                chartCol.draw(view, options);
            }

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawPieChart);

            function drawPieChart() {

                var data = google.visualization.arrayToDataTable([
                    ["Element", "Percentuale", { role: "style" } ],
                    ["Gioia", (Number(obj.joy)), "yellow"],
                    ["Tristezza", (Number(obj.sadness)), "brown"],
                    ["Disgusto", (Number(obj.disgust)), "green"],
                    ["Disprezzo", (Number(obj.contempt)), "grey"],
                    ["Rabbia", (Number(obj.anger)), "red"],
                    ["Paura", (Number(obj.fear)), "orange"],
                    ["Sorpresa", (Number(obj.surprise)), "gold"],
                ]);

                $('#engagement').html(Number(obj.engagement).toFixed(3));

                var view_p = new google.visualization.DataView(data);

                var options = {
                    title: "PieChart della media delle emozioni"
                };

                var chartPie = new google.visualization.PieChart(document.getElementById('piechart'));

                $("#showAll").click(function (){
                    view_p.setRows([0,1,2,3,4,5,6]);
                    chartPie.draw(view_p, options);
                });

                $("#drow").click(function (){
                    var selected_p=[];
                    $(".sw:checkbox:checked").each(function () {
                        selected_p.push($(this).attr('value'));
                    });
                    var stack_p = new Array();
                    for(var i=0; i<selected_p.length; i++){
                        stack_p[i] = Number(selected_p[i]);
                    }
                    view_p.setRows(stack_p);
                    chartPie.draw(view_p, options);
                });
                chartPie.draw(view_p, options);
            }
        </script>
    @endif
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

    <div class="modal fade" id="modal_analysis_project" data-backdrop="false">
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
                        <div class="col-5 p-2 font-weight-bold">
                            {{$task->nomeTask}}
                        </div>
                    </div>
                    <div class="container-fluid analysis_contain">
                        @forelse($videos as $video)
                        <div class="row w-100 analysis">
                            <div class="col-7 my-auto pl-md-5">
                                {{$video->nomeVideo}}
                                <?php
                                array_push($all_video, $video->id);
                                ?>
                            </div>
                            <div class="col-5 my-auto">
                                @if($video->risultatiAnalisi == null)
                                    <?php
                                    array_push($idAnalyze, $video->id);
                                    ?>
                                    <div id="notAnalyze_{{$video->id}}">
                                        <i class="far fa-times-circle text-danger fa-2x"></i><span class="text-danger font-weight-bold pl-2">Non analizzato</span>
                                    </div>
                                    {{--                                         <button class="btn btn_analysis btn-sm" id="{{$video->id}}" onclick="startAnalisi('{{asset($video->pathVideo)}}','{{$video->id}}','task')">Analizza</button>--}}
                                    <div id="loading_{{$video->id}}" class="loading"  style="display:none">
                                        <div class="loader mx-auto"></div>
                                        <p class="percent text-center mx-auto small" id="percent_analysis_{{$video->id}}">0%</p>
                                    </div>
                                    <div id="analyzed_{{$video->id}}" style="display:none">
                                        <i class="far fa-check-circle text-success fa-2x"></i><span class="text-success font-weight-bold pl-2">Analizzato</span>
                                    </div>
                                @else
                                    <?php $i++;?>
                                    <div id="analyzed_{{$video->id}}">
                                        <i class="far fa-check-circle text-success fa-2x"></i><span class="text-success font-weight-bold pl-2">Analizzato</span>
                                    </div>
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
                        <div class="row w-100 task_title">
                            <div class="col-5 offset-1 font-weight-bold">
                                Nessun task per questo progetto
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    @if($i==$tot)
                        <button class="btn btn_analysis" id="btn_all" onclick="projectAnalisi('{{$content->id}}',{{json_encode($all_video)}})">Analizza Task</button>
                    @elseif($tot>0)
                        <button class="btn btn_analysis" id="btn_all" onclick="analyze()">Analizza Progetto</button>
                    @endif
                    <button type="button" id="dismiss_analysis" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function analyze(){

        ids = {{json_encode($idAnalyze)}};
        len = ids.length;
        all_id = {{json_encode($all_video)}};
        var path = [];
        for (i=0;i<len;i++){
            $("#notAnalyze_"+ids[i]).hide();
            $('#loading_'+ids[i]).show();
            $.ajax({
                url:'http://127.0.0.1:8000/path_video/'+ids[i],
                type: 'POST',
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function (res) {
                    path.push(res);
                }
            });
        }
        console.log(path);

        startAnalisi(path,ids,0,len,{{$content->id}},all_id);
    }

</script>

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
                                <p id="modal_error_msg" class="mt-5 mb-5 text-center w-100 text-danger">Errore nell'analisi</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-danger">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>

@endsection
