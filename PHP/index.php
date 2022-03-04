<?php
if(!isset($_GET['u'])){
    echo $_SERVER['SERVER_ADDR'];
    exit();
}


$url = $_GET['u'];
$url = urldecode($url);
$url = base64_decode($url);
//echo $url;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
$statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

curl_close($curl);

header('Content-Type: application/json; charset=utf-8');
http_response_code($statusCode);
echo $response;
exit();