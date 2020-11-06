<?php
$VideoTask= \App\Http\Controllers\TaskController::getTaskbyId($data->task);
$TaskId=$VideoTask->id;
$TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($VideoTask->progetto);
$ProjectId=$TaskProject->id;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data->nomeVideo}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<!-- SCRIPT GRAFICI -->
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
    var json = '{{$data->risultatiAnalisi}}';
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


<body>

<div class="container-fluid">
    <div class="row" style="margin-bottom: 1%">
        <div class="col-md-12" style="text-align: center">
            <strong>FILE DI ANALISI</strong>
        </div>
    </div>

    <div class="row" style="margin: 1%">
        <div class="col-md-6" style="padding: 2%; border: 1px solid black">
            <label style="width: 100%"><b>Progetto:</b> {{$TaskProject->nome}}</label>
            <label style="width: 100%"><b>Descrizione:</b> {{$TaskProject->descrizione}}</label>
        </div>

        <div class="col-md-6" style="padding: 1%; border: 1px solid black">
            <label style="width: 100%"><b>Task:</b> {{$VideoTask->nomeTask}}</label>
            <label style="width: 100%"><b>Descrizione:</b> {{$VideoTask->descrizione}}</label>
        </div>
    </div>

    <div class="row" style="margin: 1%">
        <div class="col-md-6" style="padding: 1%; border: 1px solid black">
            <label style="width: 100%"><b>Video:</b> {{$data->nomeVideo}}</label>
        </div>
    </div>
</div>

<div class="container-fluid" style="text-align: center; margin-top: 2%;">
    <label style="width: 100%"><b>GRAFICI DEI RISULTATI</b></label>

    <div class="row" style="margin: 1%;">
        <div class="col-md-7" style="border: 1px solid black;">
            <label style="width: 100%"><b>Istogramma</b></label>
            <!-- GRAFICO ISTOGRAMMA -->
            <div class="row w-100" style="margin-top:1.5rem;">
                <div class="col-6 h-100">
                    <div id="columnchart_values" ></div>         <!-------------DIV BarChart----------------->
                </div>

            </div>
        </div>

        <div class="col-md-5" style="border: 1px solid black;">
            <label style="width: 100%"><b>Torta</b></label>
            <!-- GRAFICO TORTA -->
            <div class="col-6 h-100">
                <div id="piechart" style="display:block; float:left;"></div>        <!-------------DIV PieChart----------------->
            </div>
        </div>
    </div>
</div>


</body>
</html>
