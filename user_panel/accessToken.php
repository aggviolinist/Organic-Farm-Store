<?php
$consumer_key="Nc89cErjGG7W3Y1OEEFbSktrVbkUGmwc";
$consumer_secret="5loxc6QBnRe1QYlM";
//end point
$access_token_url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$headers = ['Content-Type:application/json; charset=utf8'];
$curl = curl_init($access_token_url);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl,CURLOPT_HEADER,FALSE);
curl_setopt($curl,CURLOPT_USERPWD, $consumer_key .  ':' . $consumer_secret);
$result = curl_exec($curl);
$status = curl_getinfo($curl);
$result = json_decode($result);
$access_token = $result->access_token;
echo $access_token;
curl_close($curl);
//echo $result;
?>
