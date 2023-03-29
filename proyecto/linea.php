<?php
session_start();
$curl = curl_init();
$opcion=$_GET["opcion"];
if(empty($opcion)){
    echo'<script type="text/javascript">
        alert("Selecciona una línea");
        window.location.href="linea.html";
        </script>';
}else{
    $opcion = explode("-", $opcion);
    $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.str_replace(" ","",$opcion[0]).'/route/';
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
    'accessToken: '.$_SESSION['accessToken'],
    'Cookie: SERVERIDP=b45a524a27860afec772689f834014cb22bcb504'
  ),
));
$response = curl_exec($curl);
$datos=json_decode($response);
echo '<link rel="stylesheet" href="linea.css" >';
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
//if(str_starts_with($datos->{'description'}, "NO data found")){
    echo'<script type="text/javascript">
        alert("NO data found, prueba con otros valores");
        window.location.href="calendario.html";
        </script>';
}else{
    echo "<p>Trayecto y horarios: Ida - Vuelta</p>";
    echo "<div id='contenedor'>";
        echo "<div id='deAaB'>";
            echo $datos->{'data'}->{'nameSectionA'}."-".$datos->{'data'}->{'nameSectionB'}."<br>";
            for($i=0;$i<sizeof($datos->{'data'}->{'stops'}->{'toB'}->{'features'});$i++){
                echo "Parada nª".($i+1)." :".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'stopName'}."-".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'stopNum'}."<br>";
                echo"      Distancia :".$datos->{'data'}->{'stops'}->{'toB'}->{'features'}[$i]->{'properties'}->{'distance'}."<br>";
            }
            echo "</div>";
            echo "<div id='deBaA'>";
            echo $datos->{'data'}->{'nameSectionB'}."-".$datos->{'data'}->{'nameSectionA'}."<br>";
            for($i=0;$i<sizeof($datos->{'data'}->{'stops'}->{'toA'}->{'features'});$i++){
                echo "Parada nª".($i+1)." :".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'stopName'}."-".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'stopNum'}."<br>";
                echo"      Distancia :".$datos->{'data'}->{'stops'}->{'toA'}->{'features'}[$i]->{'properties'}->{'distance'}."<br>";
            }
        echo "</div>";
    echo "</div>";
    echo"<a href='linea.html' style='text-decoration: none;
        color: blue;
        margin-left: 50%;
        border: solid;
        background: #6cc1e3;'>Volver</a>";
}
curl_close($curl);