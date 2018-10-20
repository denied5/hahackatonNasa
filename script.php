<?php 
$upload_dir = '';  //implement this function yourself
$img = $_POST['imgBase64'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir."image_name.png";
$success = file_put_contents($file, $data);
var_dump($upload_dir, $img, $data, $file, $success);
//header('Location: '.$_POST['return_url']);
