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
            <p style="display: inline-block;">1.49  </p>
            <input type="radio" name="astrName" checked="checked" value="Armstrong" /><span>Armstrong</span>
            <input type="radio" name="astrName" value="Luis" /><span>Luis</span>
            <input type="radio" name="astrName" value="John" /><span>Jhon</span>
            <input type="radio" name="astrName" value="Bob" /><span>Bob</span>
        </form>
        
        <div id="printBlock"></div>

        <video id="video" width="400" height="300" autoplay></video>
        <a href="#" id="capture" class="push_button red">Сфотографировать</a>
        <canvas id="canvas" width="400" height="300"></canvas>
        <img src="http://goo.gl/qgUfzX" id="photo" alt="Ваша фотография">
    </div>  

    <script type="text/javascript" src="js/webcam.js"> </script>

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