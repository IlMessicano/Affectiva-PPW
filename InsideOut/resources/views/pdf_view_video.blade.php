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
</head>


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
        <div class="col-md-6" style="border: 1px solid black;">
            <label style="width: 100%"><b>Istogramma</b></label>
            <!-- GRAFICO ISTOGRAMMA -->
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
        </div>

        <div class="col-md-6" style="border: 1px solid black;">
            <label style="width: 100%"><b>Torta</b></label>
            <!-- GRAFICO TORTA -->
        </div>
    </div>
</div>


</body>
</html>
