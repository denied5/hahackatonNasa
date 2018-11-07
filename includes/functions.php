<?php

    /**
     * functions.php
     *
     * PSY-CyberGame Startup
     *
     * Helper functions.	
     */

    require_once("constants.php");

    /*
    * Используя Microsoft API Отправляет фотографию для распознавания лица и эмоций.
    * Подробнее: https://azure.microsoft.com/en-us/services/cognitive-services/face/ 
    * Возвращает JSON ответ.
    */
    function microsoft_face_recognition($sourceImageUrl){
    	// Формируем curl запрос
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

	    // Закрываем
	    curl_close( $ch );

	    return $response;
    }


    /*
    * Сохраняет изображение формата base64, полученное с веб камеры, 
    * на сервер в папку UPLOAD_DIR. Возвращает путь к файлу.
    */
    function save_base64_image($image, $imageName){
    	// Форматируем строчку
    	$image = str_replace('data:image/png;base64,', '', $image);
	    $image = str_replace(' ', '+', $image);
	    
	    // Декодируем изображение
	    $data = base64_decode($image);
	    
	    // Путь к файлу
	    $path = UPLOAD_DIR . $imageName;
	    
	    // Записываем данные на диск
	    $success = file_put_contents($path, $data);

	    if($success === FALSE){
	    	// Не удалось сохранить
	        die("Couldn't save file " . $path);
	    }

	    return $path;
    }

    /*
    * Устонавливает соединение с базой данных и записывает в нее 
    * эмоции определенного человека.
    */
    function record_to_database($name, $time, $emotion){
    	// Устонавливаем соединение
	    $conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
	    
	    // Проверка соединения
	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }

	    // Отправка sql запроса с просьбой записи данных
	    if ($stmt = mysqli_prepare($conn, "INSERT INTO `statistics` (`name`, `time`, `anger`, `contempt`, `disgust`, `fear`, `happiness`, `neutral`, `sadness`, `surprise`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {

	        // Связываем параметры с метками
	        mysqli_stmt_bind_param($stmt, "ssssssssss", $name ,$time, $emotion["anger"] ,$emotion["contempt"], $emotion["disgust"], $emotion["fear"], $emotion["happiness"], $emotion["neutral"], $emotion["sadness"], $emotion["surprise"]);

	        // Запускаем запрос */
	        mysqli_stmt_execute($stmt);

	        // Закрываем запрос 
	    	mysqli_stmt_close($stmt);
	    }

	    // Закрываем соединение
	    mysqli_close($conn);
    }

?>	