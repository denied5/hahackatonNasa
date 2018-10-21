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
$img = $sourceImageUrl;

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
$emotion = $decode[0]["faceAttributes"]["emotion"]; 

## Добавление записи в бд
$host="localhost";
$user= "root";//"nasa";
$pass= "";//"AKN7n82l3N8n6ifC"; //установленный вами пароль
$db_name="nasa";

$link=mysqli_connect($host,$user,$pass, $db_name);

$nameAstr = $_POST['astrName'];
$time = substr($name, 0, strpos($name, '.'));
echo $nameAstr;

//Вставляем данные, подставляя их в запрос
$query = "INSERT INTO `statistics` (`name`, `time`, `anger`, `contempt`, `disgust`, `fear`, `happiness`, `neutral`, `sadness`, `surprise`) VALUES ('".$nameAstr."','".$time."', '".$emotion["anger"]."', '".$emotion["contempt"]."', '".$emotion["disgust"]."', '".$emotion["fear"]."', '".$emotion["happiness"]."', '".$emotion["neutral"]."', '".$emotion["sadness"]."', '".$emotion["surprise"]."')"
$sql = mysqli_query(query);
//Если вставка прошла успешно
if ($sql) {
    echo "<p>Work.</p>";
} else {
    echo "<p>Not work.</p>";
	printf("Errormessage: %s\n", $mysqli->error);
}


