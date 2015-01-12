<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

    header("Access-Control-Allow-Origin: $http_origin");

extract($_POST);

//set POST variables
if(isset($_GET['func'])){

$fields = $_GET;
$url = 'http://biblia.bendicion.net/func_api.php';

}else{
$fields = $_POST;
$url = 'http://biblia.bendicion.net/post-request.php';
}
/*$fields = array(
						'version' => urlencode($version),
						'palabras' => urlencode($palabras)
						//'Submit' => urlencode($Submit)
				);*/

//url-ify the data for the POST
$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

if(isset($_GET['func'])){
	$url.="?$fields_string";
}

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
if(!isset($_GET['func'])){
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
}
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);	

$result =  str_replace("$('#capitulo').change","$('#capituloabc').change",$result);
$result =  str_replace('onchange="version_column.submit();"','',$result);
$result =  str_replace('class="bendicion-bible"','class="bendicion-bible" onsubmit="return false"',$result);
$result =  str_replace('name="version_left_column"','name="version_left_column" onsubmit="return false"',$result);
$result =  str_replace('name="version_right_column"','name="version_right_column" onsubmit="return false"',$result);
$result =  str_replace('name="version_third_column"','name="version_third_column" onsubmit="return false"',$result);
$result =  str_replace('onchange="version_left_column.submit();"','',$result);
$result =  str_replace('onchange="version_right_column.submit();"','',$result);
$result =  str_replace('onchange="version_third_column.submit();"','',$result);
$result = str_replace('name="version_column"','name="version_column" onsubmit="return false"',$result);

//echo utf8_decode($result);
echo $result;
?>