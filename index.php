<!DOCTYPE html>
<html>
<head>
    <title>Detect Faces Sample</title>
	<link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
  <div class="booth" >
  	<p>1.17</p>
  	
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
  
  	
		
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "04602a602bb543738e53391b304c1381";

        // NOTE: You must use the same region in your REST call as you used to
        // obtain your subscription keys. For example, if you obtained your
        // subscription keys from westus, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the westcentralus region.
        // If you use a free trial subscription key, you shouldn't need to change 
        // this region.
        var uriBase =
            "https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect";

        // Request parameters.
        var params = {
            "returnFaceId": "true",
            "returnFaceLandmarks": "false",
            "returnFaceAttributes":
                "emotion"
        };

        // Display the image.
		console.log(time);
        var sourceImageUrl = o;
        document.querySelector("#sourceImage").src = sourceImageUrl;

        // Perform the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),

            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
            },

            type: "POST",

            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })

        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ?
                "Error. " : errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ?
                "" : (jQuery.parseJSON(jqXHR.responseText).message) ?
                    jQuery.parseJSON(jqXHR.responseText).message :
                        jQuery.parseJSON(jqXHR.responseText).error.message;
            alert(errorString);
        });
  
  // If you want the file to be visible in the browser 
  // - please modify the callback in javascript. All you
  // need is to return the url to the file, you just saved 
  // and than put the image in your browser.
});

  });
  
})();
</script>

<h1>Detect Faces:</h1>

<div id="wrapper" style="width:600px; display:table; float: left; margin-left: 30px;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        

        <textarea id="responseTextArea" class="UIInput"
                  style="width:580px; height:740px;"></textarea>
    </div>


    <div id="imageDiv" style="width:420px; display:none;">
        Source image:<br><br>

        <img id="sourceImage" width="400" />
    </div>
</div>
</body>
</html>