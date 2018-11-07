<?php
    /**
     * script.php
     *
     * PSY-CyberGame Startup
     *
     * Вызывается с index.php получая фотографию и имя астронавта для обработки и 
     * записи полученных результатов в базу данных.    
     */

    require_once("includes/functions.php");
    require_once("includes/constants.php"); 

    // Фотография с веб-камеры закодированная в base64
    $img = $_POST['imgBase64'];

    // Имя фотографии
    $imgName = $_POST['imgName'];

    // Имя астронавта
    $astrName = $_POST['astrName'];

    // Сохраняем фотографию на сервер
    save_base64_image($img, $imgName);

    // Получаем время (Имя изображения включает в себя время сохранения) 
    $time = substr($imgName, 0, strpos($imgName, '.'));

    // Ссылка на изображение
    $sourceImageUrl = "https://nasa.medispark.io/"  . $file;
   
    // Получаем ответ с microsoft face recognition
    $response = microsoft_face_recognition($sourceImageUrl);
    
    /*$response = '[{"faceId":"46e48f46-60fc-4b87-9add-aecd9d684351","faceRectangle":{"top":117,"left":485,"width":93,"height":93},"faceAttributes":{"emotion":{"anger":0.0,"contempt":0.0,"disgust":0.0,"fear":0.0,"happiness":1.0,"neutral":0.0,"sadness":0.0,"surprise":0.0}}},{"faceId":"4b8de7c8-a93d-4fce-9dde-629067501c90","faceRectangle":{"top":120,"left":217,"width":84,"height":84},"faceAttributes":{"emotion":{"anger":0.0,"contempt":0.0,"disgust":0.0,"fear":0.0,"happiness":0.375,"neutral":0.624,"sadness":0.0,"surprise":0.0}}}]';*/

    // Обработка ответа
    $decode = json_decode($response, true);

    // Костыль, потому что где-то выводяться 4 пробела
    echo "\n";
    
    // Вывод результатов
    foreach ($decode as $number => $people){ 
        $emotion = $people["faceAttributes"]["emotion"];
        foreach ($emotion as $key => $value) {
            echo "$key = $value \n";
        }
        echo "\n";
    } 

    $emotion = $decode[0]["faceAttributes"]["emotion"];

    // Запись в БД
    record_to_database($astrName, $time, $emotion);
?>
