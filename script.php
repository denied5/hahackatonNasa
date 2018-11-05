<?php   
    // Директория для загрузки фотогрфий
    $upload_dir = 'uploads/';  

    // Фотография с веб-камеры
    $img = $_POST['imgBase64'];

    // Имя фотографии
    $name = $_POST['imgName'];

    // Сохраняем фотографию на сервер
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $upload_dir.$name;
    $success = file_put_contents($file, $data);
    //TODO: обработать ошибку записи на сервер

    /*Отправка фотографии microsoft для обработки*/

    // Ссылка на изображение
    $sourceImageUrl = "https://nasa.medispark.io/"  . $file;
    //$sourceImageUrl = "https://ak4.picdn.net/shutterstock/videos/2173574/thumb/1.jpg";

    // Формируем curl запрос
    define( 'API_BASE_URL', 'https://westeurope.api.cognitive.microsoft.com/face/v1.0/detect' );
    define( 'API_PRIMARY_KEY', '3f7748279b184bb096349044a959737c' );
    
    $post_string = '{"url":"' . $sourceImageUrl . '"}';
    
    $query_params = array(
        'returnFaceId' => 'true',
        'returnFaceLandmarks' => 'false',
        'returnFaceAttributes' => 'emotion'
    );
    
    $params = '';
    
    foreach( $query_params as $key => $value ) {
        $params .= $key . '=' . $value . '&';
    }
    
    $params .= 'subscription-key=' . API_PRIMARY_KEY;

    $post_url = API_BASE_URL . "?" . $params;

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($post_string))
    );    
    curl_setopt( $ch, CURLOPT_URL, $post_url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_string );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    
    // Получаем ответ
    $response = curl_exec( $ch );
    
    /*$response = ' [{"faceId":"46e48f46-60fc-4b87-9add-aecd9d684351","faceRectangle":{"top":117,"left":485,"width":93,"height":93},"faceAttributes":{"emotion":{"anger":0.0,"contempt":0.0,"disgust":0.0,"fear":0.0,"happiness":1.0,"neutral":0.0,"sadness":0.0,"surprise":0.0}}},{"faceId":"4b8de7c8-a93d-4fce-9dde-629067501c90","faceRectangle":{"top":120,"left":217,"width":84,"height":84},"faceAttributes":{"emotion":{"anger":0.0,"contempt":0.0,"disgust":0.0,"fear":0.0,"happiness":0.375,"neutral":0.624,"sadness":0.0,"surprise":0.0}}}]';*/

    
    curl_close( $ch );

    // Обработка ответа
    $decode = json_decode($response, true);
    foreach ($decode as $number => $people){ 
        $emotion = $people["faceAttributes"]["emotion"];
        foreach ($emotion as $key => $value) {
            echo "$key = $value \n";
        }
        echo "\n";
    } 

    $emotion = $decode[0]["faceAttributes"]["emotion"];
    
    /*Запись в БД*/
    $servername = "138.201.105.20:306";
    $database = "nasa";
    $username = "nasa"//"root";
    $password = "AKN7n82l3N8n6ifC"//"";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $nameAstr = $_POST['astrName'];
    //$nameAstr = "Armstrong"
    $time = substr($name, 0, strpos($name, '.'));
    
    //Вставляем данные, подставляя их в запрос
    $sql = "INSERT INTO `statistics` (`name`, `time`, `anger`, `contempt`, `disgust`, `fear`, `happiness`, `neutral`, `sadness`, `surprise`) VALUES ('".$nameAstr."','".$time."', '".$emotion["anger"]."', '".$emotion["contempt"]."', '".$emotion["disgust"]."', '".$emotion["fear"]."', '".$emotion["happiness"]."', '".$emotion["neutral"]."', '".$emotion["sadness"]."', '".$emotion["surprise"]."')";
    
    //Если вставка прошла успешно
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

