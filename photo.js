


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
$.ajax({
  type: "POST",
  url: "script.php",
  data: { 
     imgBase64: dataURL
  }
}).done(function(o) {
  console.log('saved'); 
  // If you want the file to be visible in the browser 
  // - please modify the callback in javascript. All you
  // need is to return the url to the file, you just saved 
  // and than put the image in your browser.
});
  
  });
  
})();

