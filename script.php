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
$emotion = $decode[0]["faceAttributes"]["emotion"];

foreach ($emotion as $key => $value) {
    echo "$key = $value \n";
}

