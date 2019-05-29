<?php

$email = 'obill8252@gmail.com';
$body = '111111111111111qqqqqqqqqqqqqqqqqqqqqqqqqqQQQQQQQQQQQQQQQQ';
send_curl_post_smtp_email($email, $body);

function send_curl_post_smtp_email($email, $body){
 $url = 'https://valvadi101.com/smtp-testor/handler.php';
 $post_vars = 'a='.urlencode($email).'&b='.urlencode($body);
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);  // RETURN THE CONTENTS OF THE CALL
 $Rec_Data = curl_exec($ch);
 curl_close($ch);
 //print_r($Rec_Data);
}

?>