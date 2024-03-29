@extends('layouts.content')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('css/ViewVideo.css') }}" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Load Affectiva API -->
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2/affdex.js"></script>

    {{--    Script Analysis--}}
    <script type="text/javascript" src="{{asset('js/scriptAnalisiVideo.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('#analizza').click(function(){
                var block_body = window.parent.document.getElementsByClassName('block-body');
                $(block_body).show();
            });

            $.ajax({

            })

        });

    </script>
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
                <div class="col-md-12 text-center">
                    <div class="anteprima mx-auto">
                        <video class="w-75" controls>
                            <source src = "{{ asset($content->pathVideo)}}">
                            Video non riproducibile.
                        </video>
                    </div>
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
            <button class="btn" id="analizza" style="margin-right: 1rem;" data-toggle="modal" data-target="#modal_analysis" onclick="startAnalisi('{{asset($content->pathVideo)}}','{{$content->id}}','video')">Analizza</button>
            @else
            <div class="bottom_nav w-100 text-right">
                <form id="export_pdf_form" action="{{ route('export',['table'=>'video','id'=>$content->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="col" id="col"/>
                    <input type="hidden" name="pie" id="pie"/>
                    <input type="hidden" name="engag" id="engag" value=""/>
                    <button class="btn" id="export_pdf">Esporta PDF</button>
                </form>
            @endif
{{--                <button class="btn" data-toggle="modal" data-target="#modal_analysis"></button>--}}
        </div>
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
            $('#engag').val(Number(obj.engagement).toFixed(3));

            var view = new google.visualization.DataView(data);

            var options = {
                title: "BarChart della media delle emozioni",
                width: 500,
                height: 200,
                bar: {groupWidth: "50%"},
                legend: { position: "none" },
            };

            var divCol = document.getElementById("columnchart_values");
            var chartCol_input = document.getElementById('col');
            var chartCol = new google.visualization.ColumnChart(divCol);

            google.visualization.events.addListener(chartCol, 'ready', function () {
                divCol.innerHTML = '<img src="' + chartCol.getImageURI() + '">';
                chartCol_input.value = chartCol.getImageURI();
            });

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

            var view_p = new google.visualization.DataView(data);

            var options = {
                title: "PieChart della media delle emozioni"
            };

            var divPie = document.getElementById("piechart");
            var chartPie_input = document.getElementById('pie');
            var chartPie = new google.visualization.PieChart(divPie);

            google.visualization.events.addListener(chartPie, 'ready', function () {
                divPie.innerHTML = '<img src="' + chartPie.getImageURI() + '">';
                chartPie_input.value = chartPie.getImageURI();
            });

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

    <div class="modal fade" id="modal_analysis" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Analisi in corso
                </div>
                <div class="modal-body" style="height: 15rem">
                    <div class="container">
                        <div class="row w-100 text-center" style="margin-top: 15%">
                            <div class="col-12 align-self-center text-center">
                                <p>Stiamo analizzando {{$content->nomeVideo}}...</p>
                            </div>

                        </div>
                        <div class="loading">
                            <p id="percent_analysis_{{$content->id}}" class="text-center percent_analysis">0%</p>
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: center">
                    <p  style="color:#ff6464;text-decoration:underline">Non aggiornare la pagina durante l'analisi!</p>
                </div>
            </div>
        </div>
    </div>

@endsection
