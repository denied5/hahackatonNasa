<?php 
$upload_dir = 'uploads/';  //implement this function yourself
$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir."image_name1.png";
chmod("/uploads/image_name1.png", 0777);
$success = file_put_contents($file, $data);
var_dump($upload_dir, $img, $file, $success);

