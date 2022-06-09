<?php
// $access_token =  '045b97b5820ed07e572acbb3a485472dcced56b6';
// $long_url='https://simetrika.online/views/login/';
// $url = 'https://api-ssl.bitly.com/v3/shorten?access_token='.$access_token.'&longUrl='.$long_url;
// $ch1 = curl_init($url);  //open connection
// curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "GET"); 
// curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0 );
// curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0 );
// curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1 );
// $result = curl_exec($ch1); //execute post
// $data_array = json_decode($result);
// echo "<pre>";
// // print_r($newdata);
// echo 'Long url:  '.$long_url.'<br>';
// echo 'shortened url: '.$data_array->data->url;
$urlPost = $_POST["txtUrl"];
echo fnAcortarUrl($urlPost);

function fnAcortarUrl($urlPost)
{
    $long_url = $urlPost;
    $apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
    $genericAccessToken = '045b97b5820ed07e572acbb3a485472dcced56b6';

    $data = array(
        'long_url' => $long_url
    );
    $payload = json_encode($data);

    $header = array(
        'Authorization: Bearer ' . $genericAccessToken,
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    );

    $ch = curl_init($apiv4);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    $datos = json_decode($result);
    return $datos->link;
}
