<?php

$TaskProject= \App\Http\Controllers\ProjectController::getProjectbyId($data->progetto);
$ProjectId=$TaskProject->id;
$Video = \App\Http\Controllers\VideoController::getVideo($data->id);
?>

    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data->nomeTask}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

</head>


<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" style="text-align: center">
            <strong>FILE DI ANALISI</strong>
        </div>
    </div>

    <div class="row" >
        <div class="col-xs-6" style="border: 1px solid black">
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Progetto:</b> {{$TaskProject->nome}}</p>
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Descrizione:</b> {{$TaskProject->descrizione}}</p>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-3" style="border: 1px solid black">
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Task:</b> {{$data->nomeTask}}</p>
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Descrizione:</b> {{$data->descrizione}}</p>
        </div>
    </div>

    <div class="row"ì>
        <div class="col-md-6" style="padding: 1%; border: 1px solid black">
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Video: </b>@forelse($Video as $Video) {{$Video->nomeVideo}} | @empty novideo @endforelse</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6" style="text-align: center;margin-top:2rem">
            <strong>GRAFICI DEI RISULTATI</strong>
        </div>
    </div>

    <div class="row">
        <div class="col text-center" style="border: 1px solid black;">
            <!-- GRAFICO ISTOGRAMMA -->
            <div class="row">
                <div class="col-xs-6">
                    <div id="columnchart_values" ><img src="{{$col}}"></div>         <!-------------DIV BarChart----------------->
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center" style="border: 1px solid black;">
            <!-- GRAFICO TORTA -->
            <div class="col-xs-12">
                <div id="piechart"><img src="{{$pie}}"></div>        <!-------------DIV PieChart----------------->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center" style="border: 1px solid black;">
            <p style="position:relative;margin-top:1rem;margin-left:1rem;"><b>Engagement:</b> {{$eng}}</p>
        </div>
    </div>
</div>


</body>
</html>
