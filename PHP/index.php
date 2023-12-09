<?php
$method = $_SERVER['REQUEST_METHOD'];

$raw = array();
if($method == 'POST'){
    $rawdata = file_get_contents("php://input");
    $raw = json_decode($rawdata,true);
}

$url = '';
if(isset($_GET['u'])){
    $url = $_GET['u'];
    $url = urldecode($url);
    $url = base64_decode($url);
}

$caller = new pxCaller;
if(trim($url) != ''){
    if($method == 'POST')
        $caller->call_post($url,$raw);
    if($method == 'GET')
        $caller->call_get($url);        
    
}

header('Content-Type: application/json; charset=utf-8');
http_response_code($caller->statusCode);
echo $caller->response;
exit();




if(!isset($_GET['u'])){
    echo $_SERVER['SERVER_ADDR'];
    exit();
}



class pxCaller{
    public $response = '{}';
    public $statusCode = 0;
    
    public function call_get($url){
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
        
        $this->response = curl_exec($curl);
        $this->statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        
        curl_close($curl);
    }
    
    public function call_post($url,$data){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $this->response = curl_exec($curl);
        $this->statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        
        curl_close($curl);
    }    
}

