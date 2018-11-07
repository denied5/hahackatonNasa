var AstronautName = "Armstrong";

function onclick(e) {
    AstronautName = e.target.value;
}

for (var i = 0; i < myForm.astrName.length; i++) {
    myForm.astrName[i].addEventListener("click", onclick);
}

var time = "";

(function () {
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
    }, function (stream) {
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function (error) {
        alert('Ошибка! Что-то пошло не так, попробуйте позже.');
        console.log("The following error occurred: " + error.name);

    });
    document.getElementById('capture').addEventListener('click', function () {
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
        }).done(function (o) {

            console.log(o);

            $("#responseTextArea").val(o);
            console.log('saved');
        });
    });
})();