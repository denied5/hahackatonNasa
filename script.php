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

    // Формируем curl запрос
    define( 'API_BASE_URL', 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect' );
    define( 'API_PRIMARY_KEY', '04602a602bb543738e53391b304c1381' );
    
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
    
    curl_close( $ch );

    // Обработка ответа
    $decode = json_decode($response, true);
    foreach($decode as $people){ 
        $emotion = people["faceAttributes"]["emotion"];
        foreach ($emotion as $key => $value) {
            echo "$key = $value \n";
        }
    }  
