<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Take pictures from your webcam</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
  <div class="booth">
    <p>helooo</p>
   <video id="video" width="400" height="300" autoplay></video>
   <a href="#" id="capture" class="booth-capture-button">Сфотографировать</a>
   <canvas id="canvas" width="400" height="300"></canvas>
   <img src="http://goo.gl/qgUfzX" id="photo" alt="Ваша фотография">
  </div>
  <script src="photo.js"></script>
</body>
</html>