function media(json){
    obj_keys = Object.keys(json);
    // console.log(obj_keys);
    len = obj_keys.length;

    jsonDB = {
        "joy":"",
        "sadness":"",
        "disgust":"",
        "contempt":"",
        "anger":"",
        "fear":"",
        "surprise":"",
        "engagement":""};

    sumJoy = 0;
    sumSad = 0;
    sumDisg = 0;
    sumCon = 0;
    sumAng = 0;
    sumFea = 0;
    sumSur = 0;
    sumEng = 0;

    for (i = 1; i < len; i++) {
        sumJoy = sumJoy + json[i].joy;
        sumSad = sumSad + json[i].sadness;
        sumDisg = sumDisg + json[i].disgust;
        sumCon = sumCon + json[i].contempt;
        sumAng = sumAng + json[i].anger;
        sumFea = sumFea + json[i].fear;
        sumSur = sumSur + json[i].surprise;
        sumEng = sumEng + json[i].engagement;
        console.log(json[i]);
    }

    jsonDB.joy = sumJoy / len;
    jsonDB.sadness = sumSad / len;
    jsonDB.disgust = sumDisg / len;
    jsonDB.contempt = sumCon / len;
    jsonDB.anger = sumAng / len;
    jsonDB.fear = sumFea / len;
    jsonDB.surprise = sumSur / len;
    jsonDB.engagement = sumEng / len;

    return jsonDB;
}

function mediaProject(json){

    obj_keys = Object.keys(json);
    // console.log(obj_keys);
    len = obj_keys.length;

    jsonDB = {
        "joy":"",
        "sadness":"",
        "disgust":"",
        "contempt":"",
        "anger":"",
        "fear":"",
        "surprise":"",
        "engagement":""};

    sumJoy = 0;
    sumSad = 0;
    sumDisg = 0;
    sumCon = 0;
    sumAng = 0;
    sumFea = 0;
    sumSur = 0;
    sumEng = 0;

    for (i = 0; i < len; i++) {
        sumJoy = sumJoy + Number(json[i].joy);
        sumSad = sumSad + Number(json[i].sadness);
        sumDisg = sumDisg + Number(json[i].disgust);
        sumCon = sumCon + Number(json[i].contempt);
        sumAng = sumAng + Number(json[i].anger);
        sumFea = sumFea + Number(json[i].fear);
        sumSur = sumSur + Number(json[i].surprise);
        sumEng = sumEng + Number(json[i].engagement);
        console.log(json[i]);
    }

    jsonDB.joy = sumJoy / len;
    jsonDB.sadness = sumSad / len;
    jsonDB.disgust = sumDisg / len;
    jsonDB.contempt = sumCon / len;
    jsonDB.anger = sumAng / len;
    jsonDB.fear = sumFea / len;
    jsonDB.surprise = sumSur / len;
    jsonDB.engagement = sumEng / len;

    return jsonDB;

}

function startAnalisi(pathVideo, videoId,i,len,ProjectId,all_id) {
    /* Filename or path to your file.
    This is relative to where you are running your server.
    For example if I started my jupyter server in /Users/jcheong/affdex
    then the file /Users/jcheong/affdes/data/sample_vid.mp4 can be
    referenced as data/sample_vid.mp4
    */
    var pathFile = pathVideo[i];

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
    // detector.detectAllExpressions();

    // Init variable to save results
    var detection_results = [{}]; // for logging all detection results.
    if (typeof stop_sec === 'undefined') {
        stop_sec = Infinity
    }

    // Get video duration and set as global variable;
    var me = this, video = document.createElement('video');
    video.src = pathFile;
    var duration;
    // print success message when duration of video is loaded.
    video.onloadedmetadata = function () {
        duration = this.duration;
        console.log("Duration has been loaded for file: " + video.src)
    };

    // Initialize detector
    console.log("Initializing detector...");
    detector.start();

    //Add a callback to notify when the detector is initialized and ready for runing.
    detector.addEventListener("onInitializeSuccess", function () {
        console.log( "The detector reports initialized");
        getVideoImage(secs);

    });

    // This portion grabs image from the video
    function getVideoImage(secs) {
        video.currentTime = Math.min(Math.max(0, (secs < 0 ? video.duration : 0) + secs), video.duration);

        var percent = (video.currentTime/video.duration)*100;
        $('#percent_analysis_'+videoId[i]).html(parseInt(percent)+'%');
        video.onseeked = function (e) {
            var canvas = document.createElement('canvas');
            // canvas.height = canvas.height;
            // canvas.width = canvas.width;
            // canvas.width = 640;
            // canvas.height = 480;

            var ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            var img = new Image();
            img.src = canvas.toDataURL();
            // Pass the image to the detector to track emotions
            if (detector && detector.isRunning) {
                console.log("#logs", "Processing second : ".concat(precisionRound(secs, 3).toString()));
                detector.process(ctx.getImageData(0, 0, canvas.width, canvas.height), secs);
            }
        };
        video.onerror = function (e) {
            console.log ("Video Seeking Error");
        };
    }

    detector.addEventListener("onImageResultsSuccess", function (faces, image, timestamp) {
        // drawImage(image);
        $('#results').html("");
        var time_key = "Timestamp";
        var time_val = timestamp;
        console.log('#results', "Timestamp: " + timestamp.toFixed(2));
        console.log('#results', "Number of faces found: " + faces.length);
        // if (verbose) {
        //     log("#logs", "Number of faces found: " + faces.length);
        // }
        if (faces.length > 0) {
            // Append timestamp
            faces[0].emotions[time_key] = time_val;
            // Save both emotions and expressions
            var json = Object.assign({}, faces[0].emotions);
            console.log(json);
            detection_results.push(json);
            console.log(detection_results);

        } else {
            // If face is not detected skip entry.
            console.log('Cannot find face, skipping entry');
        }
        if (duration >= secs && stop_sec >= secs) {
            secs = secs + sec_step;
            getVideoImage(secs);
        } else {
            console.log("EndofDuration");
            var DBjson = media(detection_results);
            // console.log(DBjson);

            $.ajax({
                async: false,
                url: 'http://127.0.0.1:8000/save_json_video/'+videoId[i],
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'data': DBjson},
                success: function () {
                    if(i==(len-1)){
                        $('#loading_' + videoId[i]).hide();
                        $('#analyzed_' + videoId[i]).show();
                        projectAnalisi(ProjectId,all_id);
                        // var block_body = window.parent.document.getElementsByClassName('block-body');
                        // $(block_body).hide();
                        // window.location.reload();
                    }
                    else if(i<len){
                        $('#loading_' + videoId[i]).hide();
                        $('#analyzed_' + videoId[i]).show();
                        i++;
                        startAnalisi(pathVideo,videoId,i,len,ProjectId,all_id);
                    }
                },
                error:function (jqXHR, exception) {
                    console.log(jqXHR);
                    $("#modal_analysis").modal('hide');
                    // $("#modal_error_msg").html(jqXHR.responseText);
                    $("#modal_error_msg").html('Impossibile analizzare il file. Errore: '+jqXHR.status);
                    $("#modal_error").modal();
                }
            });
        }
    });

    function precisionRound(number, precision) {
        var factor = Math.pow(10, precision);
        return Math.round(number * factor) / factor;
    }

}

function projectAnalisi(projectId,all_id){
    all = [];
    console.log(all_id);
    len = all_id.length;
    console.log(len);
    for(i=0;i<len;i++){
        $.ajax({
            url:'http://127.0.0.1:8000/videoAnalysis/'+all_id[i],
            type: 'POST',
            async: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function (res) {
                // console.log(res);
                res = JSON.parse(res.replace('\\',""));
                all.push(res);
            }
        });
    }
    // console.log(all);
    DBproject = mediaProject(all);
    console.log(DBproject);
    $.ajax({
        url: 'http://127.0.0.1:8000/save_json_project/'+projectId,
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'data': DBproject},
        success: function () {
            var block_body = window.parent.document.getElementsByClassName('block-body');
            $(block_body).hide();
            window.location.reload();
        },
        error:function (jqXHR, exception) {
            console.log(jqXHR);
            $("#modal_analysis").modal('hide');
            // $("#modal_error_msg").html(jqXHR.responseText);
            $("#modal_error_msg").html('Impossibile analizzare il file. Errore: '+jqXHR.status);
            $("#modal_error").modal();
        }
    });

}
