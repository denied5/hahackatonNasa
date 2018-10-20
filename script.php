<?php 
$upload_dir = 'uploads/';  //implement this function yourself
$img = $_POST['imgBase64'];
$name = $_POST['imgName'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir.$name;

chmod("/".$file, 0777);
$success = file_put_contents($file, $data);
var_dump($upload_dir, $img, $file, $success);

