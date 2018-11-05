<!DOCTYPE html>
<html>

<head>
    <title>Detect Faces Sample</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
    <div class="booth">

        <form name="myForm">
            <p style="display: inline-block;">1.36</p>
            <input type="radio" name="astrName" checked="checked" value="Armstrong" /><span>Armstrong</span>
            <input type="radio" name="astrName" value="Luis" /><span>Luis</span>
            <input type="radio" name="astrName" value="Jhon" /><span>Jhon</span>
            <input type="radio" name="astrName" value="Bob" /><span>Bob</span>
        </form>
        <div id="printBlock"></div>

        <video id="video" width="400" height="300" autoplay></video>
        <a href="#" id="capture" class="push_button red">Сфотографировать</a>
        <canvas id="canvas" width="400" height="300"></canvas>
        <img src="http://goo.gl/qgUfzX" id="photo" alt="Ваша фотография">
    </div>

    <script type="text/javascript">
        var AstronautName = "Armstrong";

        function onclick(e) {
            AstronautName = e.target.value;
        }
        for (var i = 0; i < myForm.astrName.length; i++) {
            myForm.astrName[i].addEventListener("click", onclick);
        }
        var time = "";
        (function() {
            var video = document.getElementById('video'),
                canvas = document.getElementById('canvas'),
                context = canvas.getContext('2d'),
                photo = document.getElementById('photo'),
                vendorUrl = window.URL || window.webkitURL;
            navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.
            mozGetUserMedia || navigator.msGetUserMedia;
            navigator.getMedia({
                video: true,
                audio: false
            }, function(stream) {
                video.src = vendorUrl.createObjectURL(stream);
                video.play();
            }, function(error) {
                alert('Ошибка! Что-то пошло не так, попробуйте позже.');
                console.log("The following error occurred: " + error.name);

            });
            document.getElementById('capture').addEventListener('click', function() {
                context.drawImage(video, 0, 0, 400, 300);
                photo.setAttribute('src', canvas.toDataURL('image/png'));
                var dataURL = canvas.toDataURL();
                var d = new Date();

                time = d.getTime() + ".png";

                $.ajax({
                    type: "POST",
                    url: "script.php",
                    data: {
                        imgBase64: dataURL,
                        imgName: time,
                        astrName: AstronautName
                    }
                }).done(function(o) {

                    console.log(o);

                    $("#responseTextArea").val(o);
                    console.log('saved');
                });

            });

        })();
    </script>

    <h1>Detect Faces:</h1>

    <div id="wrapper" style="width:600px; display:table; float: left; margin-left: 30px;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            <textarea id="responseTextArea" class="UIInput" style="width:580px; height:640px;"></textarea>
        </div>


        <div id="imageDiv" style="width:420px; display:none;">
            Source image:<br><br>
            <img id="sourceImage" width="400" />
        </div>
    </div>
</body>

</html>