<?php
session_start();
$curl = curl_init();
$numerolinea = $_GET["linea"];
$fecha1=$_GET["fechadetalle"];
$fecha2=$_GET["fechageneral"];
if(empty($numerolinea) && empty($fecha1) && empty($fecha2)){
    echo'<script type="text/javascript">
      alert("Es obligatorio rellenar todos los campos de la opción que desea.");
        window.location.href="lineainformacion.html";
        </script>'; 
}elseif(empty($fecha2)){
    if(empty($numerolinea) || empty($fecha1)){
        echo'<script type="text/javascript">
      alert("Es obligatorio rellenar todos los campos de la opción que desea.");
        window.location.href="lineainformacion.html";
        </script>'; 
    }else{
        $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numerolinea.'/info/'.str_replace("-","",$fecha1).'/';
    }
}elseif(!empty($numerolinea) && !empty($fecha1) && !empty($fecha2)){
    echo'<script type="text/javascript">
      alert("Es obligatorio rellenar solo los campos de la opción que desea.");
        window.location.href="lineainformacion.html";
        </script>';
}else{
    $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/'.$fecha2.'/';
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
    'accessToken: '. $_SESSION['accessToken'],//361279d0-1ec5-4111-b7f3-2b6ac6364879',
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
    if(empty($fecha2)){
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            echo "Fecha :".$datos->{'data'}[$i]->{'dateRef'}."<br>";
            echo "Header A :".$datos->{'data'}[$i]->{'nameA'}."<br>";
            echo "Header A :".$datos->{'data'}[$i]->{'label'}."<br>";
        }
    }else{
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            echo "Fecha Ini :".$datos->{'data'}[$i]->{'startDate'}."<br>";
            echo "Grupo :".$datos->{'data'}[$i]->{'group'}."<br>";
            echo "Fecha Fin :".$datos->{'data'}[$i]->{'endDate'}."<br>";
        }
    }
}
curl_close($curl);