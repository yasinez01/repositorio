<?php
session_start();
$curl = curl_init();
$numeroparada = $_GET["parada"];
$metros=$_GET["metros"];
$longitud=$_GET["longitud"];
$latitud=$_GET["latitud"];
$radio=$_GET["radio"];
if(empty($numeroparada) || empty($metros)){
    $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundxy/'. $longitud.'/'. $latitud .'/'.$radio.'/';
}else{
    $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundstop/'.$numeroparada.'/'.$metros.'/';
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
        window.location.href="paradasalrededor.html";
        </script>';
}else{
    for($i=0;$i<sizeof($datos->{'data'});$i++){
        echo "stopId :".$datos->{'data'}[$i]->{'stopId'}."<br>";
        echo "Cordenadas :".$datos->{'data'}[$i]->{'geometry'}->{"coordinates"}[0]." , ".$datos->{'data'}[$i]->{'geometry'}->{"coordinates"}[1]."<br>";
        echo "nombre :".$datos->{'data'}[$i]->{'stopName'}."<br>";
        echo "direccion :".$datos->{'data'}[$i]->{'address'}."<br>";
        echo "lineas :"."<br>";
        for($j=0;$j<sizeof($datos->{'data'}[$i]->{'lines'});$j++){
            echo $datos->{'data'}[$i]->{'lines'}[$j]->{"line"}."<br>";
        }
    }
}
curl_close($curl);