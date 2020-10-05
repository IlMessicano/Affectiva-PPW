@extends('layouts.app')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Affectiva RMX - Live Mode</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2.1/affdex.js"></script>
</head>

<body>

<br>
<div class="container-fluid" >
    <div class="row" style="display: flex">
        <div class="col-md-7" id="affdex_elements" style="width:700px;height:500px;"></div>
        <div class="col-md-5">
            <div style="height:20em;">
                <strong>RISULTATO DELL'ANALISI IN TEMPO REALE:</strong>
                <br>
                <br>
                <div id="results"></div>
            </div>
        <div>
            <button id="start" onclick="onStart()">Start</button>
            <button id="stop" onclick="onStop()">Stop</button>
            <button id="reset" onclick="onReset()">Reset</button>
        </div>
        <br>
        <div>
            <strong>Detector log: </strong>
            <div id="logs"></div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">


    // SDK Needs to create video and canvas nodes in the DOM in order to function
    // Here we are adding those nodes a predefined div.
    var divRoot = $("#affdex_elements")[0];
    var width = 700;
    var height = 500;
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
        //Display canvas instead of video feed because we want to draw the feature points on it
        $("#face_video_canvas").css("display", "block");
        $("#face_video").css("display", "none");
    });

    function log(node_name, msg) {
        $(node_name).append("<span>" + msg + "</span><br />")
    }

    //function executes when Start button is pushed.
    function onStart() {
        if (detector && !detector.isRunning) {
            $("#logs").html("");
            detector.start();
        }
        log('#logs', "Clicked the start button");
    }

    //function executes when the Stop button is pushed.
    function onStop() {
        log('#logs', "Clicked the stop button");
        if (detector && detector.isRunning) {
            detector.removeEventListener();
            detector.stop();
        }
    };

    //function executes when the Reset button is pushed.
    function onReset() {
        log('#logs', "Clicked the reset button");
        if (detector && detector.isRunning) {
            detector.reset();

            $('#results').html("");
        }
    };

    //Add a callback to notify when camera access is allowed
    detector.addEventListener("onWebcamConnectSuccess", function() {
        log('#logs', "Accesso alla webcam consentito");
    });

    //Add a callback to notify when camera access is denied
    detector.addEventListener("onWebcamConnectFailure", function() {
        log('#logs', "webcam denied");
        console.log("Accesso alla webcam negato");
    });

    //Add a callback to notify when detector is stopped
    detector.addEventListener("onStopSuccess", function() {
        log('#logs', "Analisi fermata");
        $("#results").html("");
    });

    //Add a callback to receive the results from processing an image.
    //The faces object contains the list of the faces detected in an image.
    //Faces object contains probabilities for all the different expressions, emotions and appearance metrics
    detector.addEventListener("onImageResultsSuccess", function(faces, image, timestamp) {
        $('#results').html("");
        log('#results', "Tempo Trascorso: " + timestamp.toFixed(1) + " sec");
        //log('#results', "Numero di faces trovate: " + faces.length);
        if (faces.length > 0) {
            //log('#results', "Appearance: " + JSON.stringify(faces[0].appearance));
            log('#results', "Joy: " + JSON.stringify(faces[0].emotions.joy, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Sadness: " + JSON.stringify(faces[0].emotions.sadness, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Disgust: " + JSON.stringify(faces[0].emotions.disgust, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Contempt: " + JSON.stringify(faces[0].emotions.contempt, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Anger: " + JSON.stringify(faces[0].emotions.anger, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Fear: " + JSON.stringify(faces[0].emotions.fear, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Surprice: " + JSON.stringify(faces[0].emotions.surprise, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Valence: " + JSON.stringify(faces[0].emotions.valence, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            log('#results', "Engagement: " + JSON.stringify(faces[0].emotions.engagement, function(key, val) {
                return val.toFixed ? Number(val.toFixed(0)) : val;
            }));
            //log('#results', "Expressions: " + JSON.stringify(faces[0].expressions, function(key, val) {
                //return val.toFixed ? Number(val.toFixed(0)) : val;
            //}));
            //log('#results', "Emoji: " + faces[0].emojis.dominantEmoji);
            if($('#face_video_canvas')[0] != null)
                drawFeaturePoints(image, faces[0].featurePoints);

        } else
            log('#results', "Volto non rilevato");
    });

    //Draw the detected facial feature points on the image
    function drawFeaturePoints(img, featurePoints) {
        var contxt = $('#face_video_canvas')[0].getContext('2d');

        var hRatio = contxt.canvas.width / img.width;
        var vRatio = contxt.canvas.height / img.height;
        var ratio = Math.min(hRatio, vRatio);

        contxt.strokeStyle = "#FFFFFF";
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
</html>
