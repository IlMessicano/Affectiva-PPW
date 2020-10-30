@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/ViewVideo.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Load Affectiva API -->
    <script type="text/javascript" src="https://download.affectiva.com/js/3.2/affdex.js"></script>
    <!-- Load FileSaver to auto download json file. -->
    <script type="text/javascript" src="{{asset('js/FilesSaver.min.js')}}"></script>
    <!-- Load style CSS from Affectiva demo  -->
    <style type="text/css" src="{{asset('css/css')}}"></style>
    <script>function startAnalisi(pathVideo) {

            /* Filename or path to your file.
            This is relative to where you are running your server.
            For example if I started my jupyter server in /Users/jcheong/affdex
            then the file /Users/jcheong/affdes/data/sample_vid.mp4 can be
            referenced as data/sample_vid.mp4
            */
            var filename = '../'+pathVideo;

            // sec determines where in the video you would like to begin detection
            var secs=0;

            // sec_step determines the step size of extracting emotions in seconds
            var sec_step = 1;

            // stop_sec determines if you want to stop extraction at certain point of video
            // comment this portion out if you want to run it for entire video.
            // var stop_sec = 13;

            // Set verbose = true to print images and detection succes, false if you don't want info
            var verbose = true;

            // Decide whether your video has large or small face
            var faceMode = affdex.FaceDetectorMode.SMALL_FACES;
            // var faceMode = affdex.FaceDetectorMode.LARGE_FACES;

            // Decide which detector to use photo or stream
            // var detector = new affdex.PhotoDetector(faceMode);
            var detector = new affdex.FrameDetector(faceMode);

            // Initialize Emotion and Expression detectors
            detector.detectAllEmotions();
            detector.detectAllExpressions();

            // Init variable to save results
            var detection_results = []; // for logging all detection results.
            if (typeof stop_sec === 'undefined') {
                stop_sec = Infinity
            }

            // Get video duration and set as global variable;
            var me = this, video = document.createElement('video');
            video.src = filename;
            var duration;
            // print success message when duration of video is loaded.
            video.onloadedmetadata = function () {
                duration = this.duration;
                log("#logs", "Duration has been loaded for file: " + video.src)
            };

            // Initialize detector
            log("#logs", "Initializing detector...");
            detector.start();

            //Add a callback to notify when the detector is initialized and ready for runing.
            detector.addEventListener("onInitializeSuccess", function () {
                log("#logs", "The detector reports initialized");
                getVideoImage(secs);

            });

            // This portion grabs image from the video
            function getVideoImage(secs) {
                video.currentTime = Math.min(Math.max(0, (secs < 0 ? video.duration : 0) + secs), video.duration);
                video.onseeked = function (e) {
                    var canvas = document.createElement('canvas');
                    canvas.height = canvas.height;
                    canvas.width = canvas.width;
                    // canvas.width = 640;
                    // canvas.height = 480;

                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    var img = new Image();
                    img.src = canvas.toDataURL();
                    if (verbose) {
                        document.getElementById("logs").appendChild(img);
                        document.getElementById("logs").appendChild(document.createElement("br"));
                    }
                    // Pass the image to the detector to track emotions
                    if (detector && detector.isRunning) {
                        log("#logs", "Processing second : ".concat(precisionRound(secs, 3).toString()));
                        detector.process(ctx.getImageData(0, 0, canvas.width, canvas.height), secs);
                    }
                    ;
                };
                video.onerror = function (e) {
                    console.log("Video Seeking Error");
                };
            };

            detector.addEventListener("onImageResultsSuccess", function (faces, image, timestamp) {
                // drawImage(image);
                $('#results').html("");
                var time_key = "Timestamp";
                var time_val = timestamp;
                console.log('#results', "Timestamp: " + timestamp.toFixed(2));
                console.log('#results', "Number of faces found: " + faces.length);
                if (verbose) {
                    log("#logs", "Number of faces found: " + faces.length);
                }
                if (faces.length > 0) {
                    // Append timestamp
                    faces[0].emotions[time_key] = time_val;
                    // Save both emotions and expressions
                    var json = JSON.stringify(Object.assign({}, faces[0].emotions));
                    detection_results.push(json);

                    //var prova = JSON.stringify(faces[0].emotions);
                    //log("#logs", "Analisi: " + faces[0].emotions);

                } else {
                    // If face is not detected skip entry.
                    console.log('Cannot find face, skipping entry');
                }
                ;
                if (duration >= secs && stop_sec >= secs) {
                    secs = secs + sec_step;
                    getVideoImage(secs);
                } else {
                    console.log("EndofDuration");
                    var blob = new Blob([detection_results], {type: "application/json"});
                    var saveAs = window.saveAs;
                    saveAs(blob, filename.split(".")[0].concat(".json"));

                    // STAMPA A VIDEO DEI RISULTATI
                    //var myData=JSON.parse(data);
                    // log("#logs", detection_results[2]);
                }
                ;
            });

            function log(node_name, msg) {
                // Function from affectiva demo to write log on html page.
                // First var is div name, second var message.
                $(node_name).append("<span>" + msg + "</span><br />")
            }

            function precisionRound(number, precision) {
                var factor = Math.pow(10, precision);
                return Math.round(number * factor) / factor;
            }

        }
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
            <div id="columnchart_values" style="width: 600px; height: 200px;"></div>         <!-------------DIV BarChart----------------->
            <div id="piechart" style="width: 500px; height: 200px;"></div>                   <!-------------DIV PieChart----------------->
            </div>
        </div>
    </div>

    <div id="logs"></div>

    <p id="demo"></p>

    <div class="bottom_nav w-100 text-right">

        <button class="btn" style="margin-left: 1rem" onclick="startAnalisi('{{$content->pathVideo}}')">Analizza</button>
        <a class="btn" id="Grafici" style="margin-right: 1rem">Grafici</a>
        <a class="btn">Esporta PDF</a>
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

        //log('#results', "Valore della media: " + media(obj, "joy"));

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
                ["Valenza", (media(obj, "valence")), "heavenly"],
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
                ["Valenza", (media(obj, "valence")), "heavenly"],
                ["Engagement", (media(obj, "engagement")), "blue"]
            ]);

            var options = {
                title: "PieChart della media delle emozioni"
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

    </script>

@endsection
