@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewVideo.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

    <div class="container-fluid h-100">
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
                <div class="col-md-5 text-center">
                    <div class="anteprima mx-auto">
                            ANTEPRIMA VIDEO
                    </div>
                </div>

            </div>
            <div id="Grafici_A" style="display: none">
                <b>Seleziona le emozioni che desideri visualizzare e clicca su: Disegna Grafico</b>
                <br>
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
                <button id="drow">Disegna Grafico</button>
                <button id="showAll">Mostra Tutte</button>
                <br><br>
            <div id="columnchart_values" style="display:block; float:left; width: 600px; height: 200px;"></div>         <!-------------DIV BarChart----------------->
            <div id="piechart" style="display:block; float:right; width: 500px; height: 200px;"></div>                   <!-------------DIV PieChart----------------->
            </div>
        </div>
    </div>

    <div class="bottom_nav w-100 text-right">
        <a class="btn" style="margin-right: 1rem">Analizza</a>
        <a class="btn" id="Grafici" style="margin-right: 1rem">Grafici</a>
        <a class="btn" href="{{ route('export',['table'=>'video','id'=>$content->id]) }}">Esporta PDF</a>
    </div>

    <script>
        $("#Grafici").click(function(){
            $("#Grafici_A").show();
        });
    </script>

    <script type="text/javascript">
        var json = '{ "emozioni" : [' +
            '{"joy":0.0018286043778061867,"sadness":0.024858392775058746,"disgust":0.42589646577835083,"contempt":0.19267813861370087,"anger":0.0019392422400414944,"fear":0.004573768470436335,"surprise":0.19482466578483582,"valence":0,"engagement":0.0790390819311142,"Timestamp":0,"smile":6.410675723600434e-7,"innerBrowRaise":0.5107731223106384,"browRaise":0.007099563721567392,"browFurrow":0.0010720017598941922,"noseWrinkle":0.000014336721505969763,"upperLipRaise":2.3273962312941876e-8,"lipCornerDepressor":0.0003939382149837911,"chinRaise":0.000054273543355520815,"lipPucker":0.002205966040492058,"lipPress":0.0020638119895011187,"lipSuck":0.00026066976715810597,"mouthOpen":0.0021535861305892467,"smirk":0.00004123039252590388,"eyeClosure":2.1328178112511864e-10,"attention":95.58929443359375,"lidTighten":0.009127308614552021,"jawDrop":0.02821747399866581,"dimpler":0.001369896694086492,"eyeWiden":0.00004557651118375361,"cheekRaise":0.000039874499634606764,"lipStretch":0.0035369873512536287},' +
            '{"joy":0.001825083396397531,"sadness":0.03451100364327431,"disgust":0.4259672462940216,"contempt":0.19267970323562622,"anger":0.0016613132320344448,"fear":0.005388293415307999,"surprise":0.2190401554107666,"valence":0,"engagement":0.07936939597129822,"Timestamp":90,"smile":2.1079275214219706e-8,"innerBrowRaise":5.840742588043213,"browRaise":0.0644834116101265,"browFurrow":0.0016617377987131476,"noseWrinkle":0.00001920035902003292,"upperLipRaise":0.000010710565220506396,"lipCornerDepressor":0.0014240603195503354,"chinRaise":0.00014936366642359644,"lipPucker":0.003259174292907119,"lipPress":0.002632295247167349,"lipSuck":0.000051785162213491276,"mouthOpen":0.0015832975041121244,"smirk":0.000013080577446089592,"eyeClosure":8.129508486743112e-14,"attention":98.15471649169922,"lidTighten":0.032821137458086014,"jawDrop":0.04013534262776375,"dimpler":0.0016560613876208663,"eyeWiden":0.7740619778633118,"cheekRaise":0.0000603303087700624,"lipStretch":0.002420162782073021},' +
            '{"joy":0.001827162690460682,"sadness":0.027932915836572647,"disgust":0.4260115921497345,"contempt":0.19270895421504974,"anger":0.0018304064869880676,"fear":0.004706221632659435,"surprise":0.20176568627357483,"valence":0,"engagement":0.0790841281414032,"Timestamp":180,"smile":5.329586727498281e-8,"innerBrowRaise":2.253798484802246,"browRaise":0.014338518492877483,"browFurrow":0.009351840242743492,"noseWrinkle":0.00007672862557228655,"upperLipRaise":0.00352970277890563,"lipCornerDepressor":0.0009515571291558444,"chinRaise":0.00004173240085947327,"lipPucker":0.0028502962086349726,"lipPress":0.002953266492113471,"lipSuck":0.00006370199844241142,"mouthOpen":0.001596001093275845,"smirk":0.0000870938747539185,"eyeClosure":1.4205863863026025e-7,"attention":98.3512954711914,"lidTighten":0.009573271498084068,"jawDrop":0.046124037355184555,"dimpler":0.001810286776162684,"eyeWiden":0.0007127904682420194,"cheekRaise":0.00010578271758276969,"lipStretch":0.003680300898849964},' +
            '{"joy":0.0018142219632863998,"sadness":0.03602369874715805,"disgust":0.4260026812553406,"contempt":0.193086639046669,"anger":0.001631418359465897,"fear":0.005018965341150761,"surprise":0.2160487174987793,"valence":0,"engagement":0.07965773344039917,"Timestamp":270,"smile":6.938428498415306e-8,"innerBrowRaise":5.956593036651611,"browRaise":0.022459812462329865,"browFurrow":0.1142926886677742,"noseWrinkle":0.00007116514461813495,"upperLipRaise":0.0006432249792851508,"lipCornerDepressor":0.0008983812876977026,"chinRaise":0.000038162113924045116,"lipPucker":0.002558236476033926,"lipPress":0.0042551797814667225,"lipSuck":0.00012565516226459295,"mouthOpen":0.0030786427669227123,"smirk":0.000028622829631785862,"eyeClosure":9.633609188153258e-11,"attention":98.4405517578125,"lidTighten":0.0290498249232769,"jawDrop":0.06309093534946442,"dimpler":0.003750542178750038,"eyeWiden":0.0005426140269264579,"cheekRaise":0.00010304156603524461,"lipStretch":0.002984298625960946}]}';
        var obj = JSON.parse(json);

        function log(node_name, msg) {
            $(node_name).append("<span>" + msg + "</span><br />")
        }
        //log('#results', "Valore del json: " + obj.emozioni.length);


        function media(json, emozione){

            sum = 0;

            switch (emozione) {
                case "joy":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].joy;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "sadness":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].sadness;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "disgust":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].disgust;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "contempt":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].contempt;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "anger":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].anger;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "fear":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].fear;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "surprise":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].surprise;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "valence":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].valence;
                        media_f = sum / obj.emozioni.length;
                    }
                    break;
                case "engagement":
                    for (i = 0; i < obj.emozioni.length; i++) {
                        sum = sum + obj.emozioni[i].engagement;
                        media_f = sum / obj.emozioni.length;
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
