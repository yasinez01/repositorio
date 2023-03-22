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
if(empty($fecha2)){
    $url_calendario='https://openapi.emtmadrid.es/v1/transport/busemtmad/calendar/'.str_replace("-","",$fecha1).'/'.str_replace("-","",$fecha1).'/';
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_calendario,
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
            $tipodia=$datos->{'data'}[0]->{'dayType'};
        }
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
            echo "DESDE :".$datos->{'data'}[$i]->{'nameA'}."<br>";
            echo "HASTA :".$datos->{'data'}[$i]->{'nameB'}."<br>";
            for($j=0;$j<sizeof($datos->{'data'}[$i]->{'timeTable'});$j++)
                if($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}==$tipodia){
                    if($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="LA") echo "Tipo de día : Día laborable <br>";
                    elseif($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="SA") echo "Tipo de día : Sábado <br>";
                    else echo "Tipo de día : Día festivo<br>";
                    echo "Direccion 1:"."<br>";
                    echo "Hora Inicio :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'StartTime'}."<br>";
                    echo "Hora Fin :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'StopTime'}."<br>";
                    echo "Minima Frecuencia de minutos de espera :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'MinimunFrequency'}."<br>";
                    echo "Máxima Frecuencia de minutos de espera :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'MaximumFrequency'}."<br>";
                    echo "Direccion 2:"."<br>";
                    echo "Hora Inicio :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'StartTime'}."<br>";
                    echo "Hora Fin :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'StopTime'}."<br>";
                    echo "Minima Frecuencia de minutos de espera :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'MinimunFrequency'}."<br>";
                    echo "Máxima Frecuencia de minutos de espera :".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'MaximumFrequency'}."<br>";
                }
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