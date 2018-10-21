<!DOCTYPE html>
<html>
<head>
    <title>Detect Faces Sample</title>
	<link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
  <div class="booth">
  	<p>1.15</p>
  	
   <video id="video" width="400" height="300" autoplay></video>
   <a href="#" id="capture" class="booth-capture-button">Сфотографировать</a>
   <canvas id="canvas" width="400" height="300"></canvas>
   <img src="http://goo.gl/qgUfzX" id="photo" alt="Ваша фотография">
  </div>
  <script src="photo.js"></script>

<script type="text/javascript">
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

  });
  document.getElementById('capture').addEventListener('click', function() {
   context.drawImage(video, 0, 0, 400, 300);
   photo.setAttribute('src', canvas.toDataURL('image/png'));
  var dataURL = canvas.toDataURL();
  var d = new Date();
 
  time = d.getTime()+".png";
  
$.ajax({
  type: "POST",
  url: "script.php",
  data: { 
     imgBase64: dataURL,
     imgName: time
  }
}).done(function(o) {
  
  console.log(o);
  console.log('saved'); 
});

  });
  
})();
</script>

<h1>Detect Faces:</h1>

<div id="wrapper" style="width:1020px; display:table;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        Response:<br><br>

        <textarea id="responseTextArea" class="UIInput"
                  style="width:580px; height:400px;"></textarea>
    </div>
    <div id="imageDiv" style="width:420px; display:table-cell;">
        Source image:<br><br>

        <img id="sourceImage" width="400" />
    </div>
</div>
</body>
</html>