<?php 
$upload_dir = 'uploads/';  //implement this function yourself
$img = $_POST['imgBase64'];
$name = $_POST['imgName'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir.$name;

$success = file_put_contents($file, $data);

$sourceImageUrl = "https://nasa.medispark.io/"  . $file;

//echo $sourceImageUrl;
define( 'API_BASE_URL',     'https://westcentralus.api.cognitive.microsoft.com/face/v1.0/detect' );
define( 'API_PRIMARY_KEY',      '04602a602bb543738e53391b304c1381' );
$img = 'https://nasa.medispark.io/uploads/image_name.png';

$post_string = '{"url":"' . $img . '"}';

$query_params = array(
     "returnFaceId" => "true",
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
    $response = curl_exec( $ch );
curl_close( $ch );

$decode = json_decode($response, true);
var_dump($decode[0]["faceAttributes"]["emotion"]);




















exit;
$sourceImageUrl = "https://nasa.medispark.io/uploads/image_name.png";
$params = [
            "returnFaceId" => "true",
            "returnFaceLandmarks"=> "false",
            "returnFaceAttributes" => "emotion"
];

$regUrl = "https://nasa.medispark.io/uploads/1540079058060.png";
$data = '{"url": ' . '"' . $sourceImageUrl . '"}';
                       
$data = ['data'=>["url" => $sourceImageUrl]];                                
$data_string = json_encode($data); 
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $regUrl); //урл сайта к которому обращаемся
	curl_setopt($curl, CURLOPT_POST, 1); //передача данных методом POST
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //теперь curl вернет нам ответ, а не выведет
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    "Ocp-Apim-Subscription-Key: 04602a602bb543738e53391b304c1381",
));
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, //тут переменные которые будут переданы методом POST
	$data_string);
	
	$res = curl_exec($curl);
var_dump($res);
	//если ошибка то печатаем номер и сообщение
	if(!$res) {
		$error = curl_error($curl).'('.curl_errno($curl).')';
		echo $error;
	}
	else {
		//если результат содержит то что нам надо (проверяем регуляркой), а в данном случае это табличка с классом yaResultat, то выводим ее.
		if (preg_match("/\<table class\='yaResultat'(.+)\<\/table\>/isU", $res, $found)) {
			$content = $found[0];
			echo $content; //перед этим его конечно можно обработать всякими str_replace и т.д.
		}
		else {
			echo "<p>Неизвестная ошибка</p>"; //а если табличики с результатами нет, то печатать нечего и мы незнаем что делать :(
		}
	}
curl_close($curl);

var_dump($upload_dir, $img, $file, $success);


