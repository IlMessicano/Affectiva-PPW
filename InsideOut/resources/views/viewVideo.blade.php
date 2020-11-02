@extends('layouts.content')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('css/ViewVideo.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Load Affectiva API -->
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2/affdex.js"></script>
    <script type="text/javascript" src="{{asset('js/scriptAnalisi.js')}}"></script>
@endsection

<?php
$VideoTask= \App\Http\Controllers\TaskController::getTaskbyId($content->task);
$TaskId=$VideoTask->id;
$TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($VideoTask->progetto);
$ProjectId=$TaskProject->id;
?>

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('project', ['id' => $ProjectId ])}}">{{$TaskProject->nome}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('task', ['id' => $TaskId ])}}">{{$VideoTask->nomeTask}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$content->nomeVideo}}</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row top_video">
            <div class="row w-100 top1_video">
                <div class="col-sm-12 text-center align-content-center title">
                    {{$content->nomeVideo}}<span class="modify" data-toggle="modal" data-target="#modal_modify_video"><i class="fas fa-pencil-alt"></i></span>
                </div>
            </div>
            <div class="row w-100 top2_video">
                <div class="col-md-3 offset-md-2 text-center my-auto font-weight-bold">
                    Anteprima:
                </div>
                <div class="col-md-5 offset-md-2 text-center">
                    <div class="anteprima mx-auto">
                        <video class="w-100 h-100" controls >
                            <source src = "{{ asset($content->pathVideo)}}">
                            Video non riproducibile.
                        </video>
                    </div>
                </div>
            </div>
        </div>
        @if($content->risultatiAnalisi == null)
        <div class="row w-100" hidden id="Grafici_A" style="padding-left:3rem">
        @else
        <div class="row w-100" id="Grafici_A" style="padding-left:3rem">
        @endif
            <div class="row w-100">
                <p class="font-weight-bold pt-2">Seleziona le emozioni che desideri visualizzare e clicca su: Disegna Grafico</p>
                <form id="sw" action="" method="post">
                    <input class="sw" name="sw[]" type = "checkbox" value='0'> Gioia
                    <input class="sw" name="sw[]" type = "checkbox" value='1'> Tristezza
                    <input class="sw" name="sw[]" type = "checkbox" value='2'> Disgusto
                    <input class="sw" name="sw[]" type = "checkbox" value='3'> Disprezzo
                    <input class="sw" name="sw[]" type = "checkbox" value='4'> Rabbia
                    <input class="sw" name="sw[]" type = "checkbox" value='5'> Paura
                    <input class="sw" name="sw[]" type = "checkbox" value='6'> Sorpresa
                    <input class="sw" name="sw[]" type = "checkbox" value='7'> Engagement
                </form>
            </div>
            <div class="row w-100">
                <div class="col-2 offset-md-1">
                    <button class="btn" id="drow">Disegna Grafico</button>
                </div>
                <div class="col-2 offset-md-1">
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
        </div>

            @if($content->risultatiAnalisi == null)
            <div class="bottom_nav w-100 text-right"style="position:absolute;bottom:4%">
            <button class="btn" style="margin-right: 1rem;" onclick="startAnalisi('{{asset($content->pathVideo)}}','{{$content->id}}')">Analizza</button>
            @else
            <div class="bottom_nav w-100 text-right">
            <button class="btn" style="margin-right: 1rem" disabled>Analizza</button>
            @endif
                {{--            <a class="btn" id="Grafici" style="margin-right: 1rem">Grafici</a>--}}
            <a class="btn" href="{{ route('export',['table'=>'video','id'=>$content->id]) }}">Esporta PDF</a>
        </div>
    </div>

    <script>
        $("#Grafici").click(function(){
            $("#Grafici_A").fadeIn();
            $(".bottom_nav").css({
                'position':'relative',
                'top': '4%',
                'height': '4rem',
                'padding-right': '5%'
            });
            $("#Grafici").addClass('disabled');
        });
    </script>

    <script type="text/javascript">
        var json = '{{$content->risultatiAnalisi}}';
        var obj = JSON.parse(json.replace(/&quot;/g,'"'));
        console.log(obj);
        function log(node_name, msg) {
            $(node_name).append("<span>" + msg + "</span><br />")
        }
        //log('#results', "Valore del json: " + obj.emozioni.length);
        var obj_keys = Object.keys(obj);
        console.log(obj_keys);
        var len = obj_keys.length;
        function media(json, emozione){

            sum = 0;

            switch (emozione) {
                case "joy":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].joy);
                        media_f = sum / len;
                    }
                    break;
                case "sadness":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].sadness);
                        media_f = sum / len;
                    }
                    break;
                case "disgust":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].disgust);
                        media_f = sum / len;
                    }
                    break;
                case "contempt":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].contempt);
                        media_f = sum / len;
                    }
                    break;
                case "anger":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].anger);
                        media_f = sum / len;
                    }
                    console.log(sum);
                    break;
                case "fear":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].fear);
                        media_f = sum / len;
                    }
                    break;
                case "surprise":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].surprise);
                        media_f = sum / len;
                    }
                    break;
                case "valence":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].valence);
                        media_f = sum / len;
                    }
                    break;
                case "engagement":
                    for (i = 1; i <= len; i++) {
                        sum = sum + Number(obj[i].engagement);
                        media_f = sum / len;
                    }
                    break;
            }
            return media_f;
        }

        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Percentuale", { role: "style" } ],
                ["Gioia", (media(obj, "joy")), "yellow"],
                ["Tristezza", (media(obj, "sadness")), "brown"],
                ["Disgusto", (media(obj, "disgust")), "green"],
                ["Disprezzo", (media(obj, "contempt")), "grey"],
                ["Rabbia", (media(obj, "anger")), "red"],
                ["Paura", (media(obj, "fear")), "orange"],
                ["Sorpresa", (media(obj, "surprise")), "gold"],
                ["Engagement", (media(obj, "engagement")), "blue"]
            ]);

            var view = new google.visualization.DataView(data);

            var options = {
                title: "BarChart della media delle emozioni",
                width: 500,
                height: 200,
                bar: {groupWidth: "50%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));

            $("#showAll").click(function (){
                view.setRows([0,1,2,3,4,5,6,7]);
                chart.draw(view, options);
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
                chart.draw(view, options);
            });
            chart.draw(view, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ["Element", "Percentuale", { role: "style" } ],
                ["Gioia", (media(obj, "joy")), "yellow"],
                ["Tristezza", (media(obj, "sadness")), "brown"],
                ["Disgusto", (media(obj, "disgust")), "green"],
                ["Disprezzo", (media(obj, "contempt")), "grey"],
                ["Rabbia", (media(obj, "anger")), "red"],
                ["Paura", (media(obj, "fear")), "orange"],
                ["Sorpresa", (media(obj, "surprise")), "gold"],
                ["Engagement", (media(obj, "engagement")), "blue"]
            ]);

            var view_p = new google.visualization.DataView(data);

            var options = {
                title: "PieChart della media delle emozioni"
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            $("#showAll").click(function (){
                view_p.setRows([0,1,2,3,4,5,6,7]);
                chart.draw(view_p, options);
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
                chart.draw(view_p, options);
            });
            chart.draw(view_p, options);
        }
    </script>
@endsection

@section('modals')

    <div class="modal fade" id="modal_modify_video" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Modifica Video</h5>
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
                                        <input id="nomeVideo" type="text" class="input form-control @error('nome') is-invalid @enderror" name="nomeVideo" value="{{ $content->nomeVideo }}" required autocomplete="nome" >
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

    <div class="modal fade" id="modal_error" data-backdrop="false">
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
                        <p id="modal_error_msg" class="mt-5 mb-5 text-center w-100 text-danger">aaaaaaaa</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-danger">Chiudi</button>
                </div>
            </div>
        </div>
    </div>


@endsection
