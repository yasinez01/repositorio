<?php
session_start();
$curl = curl_init();
//$usur = $_GET["text"];
//$password=$_GET["password"];
curl_setopt_array($curl, array(
  CURLOPT_URL =>'https://openapi.emtmadrid.es/v1/mobilitylabs/user/login/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    //'email: '.$usur,//yasinezziani@gmail.com',
    'email: yasinezziani@gmail.com',
    //'password: '.$password, //@2001yasinA',
    'password: @2001yasinA',
    'Cookie: SERVERIDP=71c191fa49acbbd36b480b3d575968dd658b92cf'
  ),
));

$response = curl_exec($curl);
$losdatos=json_decode($response);
#var_dump($losdatos); # ver la estructura de los datos
#echo($losdatos->{'code'}); # ver variable 'code'
$accessToken=$losdatos->{'data'}[0]->{'accessToken'}; 
$_SESSION['accessToken']= $accessToken; 
echo'<script type="text/javascript">
      alert("AccessToken conseguido");
        window.location.href="web.html";
        </script>'; 