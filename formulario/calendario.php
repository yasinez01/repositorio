<?php
session_start();
$curl = curl_init();
$fechaini=$_GET["fechaini"];
$fechafin=$_GET["fechafin"];
if(empty($fechafin) || empty($fechaini)){
    echo'<script type="text/javascript">
        alert("Rellene todos los campos");
        window.location.href="calendario.html";
        </script>';
}else{
    $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/calendar/'.str_replace("-","",$fechaini).'/'.str_replace("-","",$fechafin).'/';
}
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
    'accessToken: '.$_SESSION['accessToken'],//9a6b9c9d-912b-4c77-917a-a0a603a3614f',
    'Cookie: SERVERIDP=b45a524a27860afec772689f834014cb22bcb504'
  ),
));

$response = curl_exec($curl);
$datos=json_decode($response);
if(str_starts_with($datos->{'description'}, "NO data found")){
    echo'<script type="text/javascript">
        alert("NO data found, prueba con otros valores");
        window.location.href="calendario.html";
        </script>';
}else{
    for($i=0;$i<sizeof($datos->{'data'});$i++){
        echo "dia :".$datos->{'data'}[$i]->{'date'}."<br>";
        if($datos->{'data'}[$i]->{'strike'} == "N") echo "huelga : NO<br>";
        else echo "huelga: SI<br>";
        if($datos->{'data'}[$i]->{'dayType'}=="LA") echo "tipo de día : Día laborable <br>";
        elseif($datos->{'data'}[$i]->{'dayType'}=="SA") echo "tipo de día : Sábado <br>";
        else echo "tipo de día : Día festivo<br>";
    }
}
curl_close($curl);