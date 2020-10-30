function startAnalisi(pathVideo) {

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
