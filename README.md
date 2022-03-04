# web-proxy
A handy web proxy developed in different languages!

# Using
For PHP:

```bash
<?php
$proxy_url = 'https://www.google.com';
$proxy_url = base64_encode($proxy_url);
$proxy_url = urlencode($proxy_url);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://your-url.com/?u=' . $proxy_url,
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

curl_close($curl);
echo $response;
```