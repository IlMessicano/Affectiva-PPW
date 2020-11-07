@extends('layouts.app')

@section('content')
<head>
    <title>Affectiva RMX - Live Mode</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2.1/affdex.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
<div class="container-fluid" >
    <div class="row">
        <a class="btn" style="margin: 1%" href="{{route('login')}}">Login</a>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align: center">
            <h2>LIVE MODE</h2>
            <button class="btn btn-success" id="start" onclick="onStart()">Start</button>
            <button class="btn btn-danger" id="stop" onclick="onStop()">Stop</button>
        </div>
    </div>
    <div class="row" style="display: flex; margin: auto; height:40%;">
        <div class="col-6 text-center">
            <div id="affdex_elements" ></div>
        </div>
        <div class="col-6 text-center">
            <div id="columnchart_values" style="width: 80%; height: 100%;margin:auto"></div>
        </div>
        <p style="display:none; padding-top: 1%; padding-left: 65%" id="visualizza">Valore dell'Engagement:&nbsp<p style="padding-top: 1%" id="engag"></p></p>
    </div>
    <!-------------DIV Grafico----------------->
    <div class="row">
        <div class="col-md-12" style="text-align: center; margin-top: 1%">
            <strong>Detector log: </strong>
            <div id="logs"></div>
        </div>

    </div>

</div>

<script type="text/javascript">
    // SDK Needs to create video and canvas nodes in the DOM in order to function
    // Here we are adding those nodes a predefined div.
    var divRoot = $("#affdex_elements")[0];
    var width = 350;
    var height = 250;
    var faceMode = affdex.FaceDetectorMode.LARGE_FACES;
    //Construct a CameraDetector and specify the image width / height and face detector mode.
    var detector = new affdex.CameraDetector(divRoot, width, height, faceMode);

    //Enable detection of all Expressions, Emotions and Emojis classifiers.
    detector.detectAllEmotions();
    detector.detectAllExpressions();
    detector.detectAllEmojis();
    detector.detectAllAppearance();

    //Add a callback to notify when the detector is initialized and ready for runing.
    detector.addEventListener("onInitializeSuccess", function() {
        log('#logs', "Analisi avviata");

    });

    function log(node_name, msg) {
        $(node_name).append("<span>" + msg + "</span><br />")
    }

    //function executes when Start button is pushed.
    function onStart() {
        log('#logs', "Clicked the start button");
        if (detector && !detector.isRunning) {
            $("#logs").html("");
            detector.start();
            $("#face_video_canvas").css({"display":"block", "border":"2px solid #90A8B3", "margin":"auto"});
            $("#face_video").css({"display": "none"});
            $("#visualizza").show();
        }

    }

    //function executes when the Stop button is pushed.
    function onStop() {
        log('#logs', "Clicked the stop button");
        if (detector && detector.isRunning) {
            detector.removeEventListener();
            detector.stop();
        }
    }

    //Add a callback to notify when camera access is allowed
    detector.addEventListener("onWebcamConnectSuccess", function() {
        log('#logs', "Accesso alla webcam consentito");
    });

    //Add a callback to notify when camera access is denied
    detector.addEventListener("onWebcamConnectFailure", function() {
        log('#logs', "Accesso alla webcam negato");
       // console.log("Accesso alla webcam negato");
    });

    //Add a callback to notify when detector is stopped
    detector.addEventListener("onStopSuccess", function() {
        log('#logs', "Analisi arrestata");
    });

    //Add a callback to receive the results from processing an image.
    //The faces object contains the list of the faces detected in an image.
    //Faces object contains probabilities for all the different expressions, emotions and appearance metrics
    detector.addEventListener("onImageResultsSuccess", function(faces, image, timestamp) {
        if (faces.length > 0) {

            google.charts.load("current", {packages:['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Percentuale", { role: "style" } ],
                    ["Gioia", (faces[0].emotions.joy), "yellow"],
                    ["Tristezza", (faces[0].emotions.sadness), "brown"],
                    ["Disgusto", (faces[0].emotions.disgust), "green"],
                    ["Disprezzo", (faces[0].emotions.contempt), "grey"],
                    ["Rabbia", (faces[0].emotions.anger), "red"],
                    ["Paura", (faces[0].emotions.fear), "orange"],
                    ["Sorpresa", (faces[0].emotions.surprise), "gold"],
                    ["Engagement", (faces[0].emotions.engagement), "blue"]
                ]);

                $('#engag').html((faces[0].emotions.engagement).toFixed(3));
                var view = new google.visualization.DataView(data);
                var options = {
                    title: "Grafico delle emozioni in tempo reale",
                    bar: {groupWidth: "50%"},
                    legend: { position: "none" },
                };

                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }

            if($('#face_video_canvas')[0] != null)
                drawFeaturePoints(image, faces[0].featurePoints);

        } else
            log('#log', "VOLTO NON RILEVATO!");
    });

    //Draw the detected facial feature points on the image
    function drawFeaturePoints(img, featurePoints) {
        var contxt = $('#face_video_canvas')[0].getContext('2d');

        var hRatio = contxt.canvas.width / img.width;
        var vRatio = contxt.canvas.height / img.height;
        var ratio = Math.min(hRatio, vRatio);

        contxt.strokeStyle = "#ffffff";
        for (var id in featurePoints) {
            contxt.beginPath();
            contxt.arc(featurePoints[id].x,
                featurePoints[id].y, 2, 0, 2 * Math.PI);
            contxt.stroke();

        }
    }

 </script>

<script>
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent){
        window.parent.parent.postMessage(["resultsFrame", {
            height: document.body.getBoundingClientRect().height,
            slug: "opyh5e8d"
        }], "*")
    }

    // always overwrite window.name, in case users try to set it manually
    window.name = "result"
</script>

</body>
@endsection
