<?php
require 'Consulta.php';
error_reporting(0);
session_start();
$numerolinea = $_GET["linea"];
$fecha1=$_GET["fechadetalle"];
$fecha2=$_GET["fechageneral"];
$Consulta = new Consulta();
$isAllEmpty= empty($numerolinea) && empty($fecha1) && empty($fecha2); 
$isNoneEmpty= !empty($numerolinea) && !empty($fecha1) && !empty($fecha2); 
$emptyopcion1=empty($numerolinea) && empty($fecha1);
$notallopcion1=empty($numerolinea) || empty($fecha1);
$emptyopcion2= empty($fecha2);
if($isAllEmpty) {
    echo'<script type="text/javascript">
      alert("Es obligatorio rellenar todos los campos de la opción que desea.");
        window.location.href="lineainformacion.html";
        </script>'; 
}else{
    if($emptyopcion1){
        $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/lines/info/'.$fecha2.'/';
    }else{
        if (($isNoneEmpty)) {
            echo'<script type="text/javascript">
              alert("Es obligatorio rellenar solo los campos de una opción.");
                window.location.href="lineainformacion.html";
                </script>';
        }else{
            if(!$emptyopcion2){
                echo'<script type="text/javascript">
              alert("Es obligatorio rellenar solo los campos de una opción.");
                window.location.href="lineainformacion.html";
                </script>';
            }else{
                if($notallopcion1){
                    echo'<script type="text/javascript">
                alert("Es obligatorio rellenar todos los campos de la opción que desea.");
                    window.location.href="lineainformacion.html";
                    </script>';
                }else{
                    $url='https://openapi.emtmadrid.es/v1/transport/busemtmad/lines/'.$numerolinea.'/info/'.str_replace("-","",$fecha1).'/';  
                } 
            } 
        }
    }
}
if($emptyopcion2){
    $url_calendario='https://openapi.emtmadrid.es/v1/transport/busemtmad/calendar/'.str_replace("-","",$fecha1).'/'.str_replace("-","",$fecha1).'/';
    $datos=$Consulta->realizarconsulta($url_calendario,'GET');
        if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
            echo'<script type="text/javascript">
                alert("NO data found, prueba con otros valores");
                window.location.href="paradasalrededor.html";
                </script>';
        }else{
            $tipodia=$datos->{'data'}[0]->{'dayType'};
        }
}
$datos=$Consulta->realizarconsulta($url,'GET');
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
    echo'<script type="text/javascript">
        alert("NO data found, prueba con otros valores");
        window.location.href="paradasalrededor.html";
        </script>';
}else{
    if($emptyopcion2){
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
    echo"<a href='lineainformacion.html' style='text-decoration: none;
        color: blue;
        margin-left: 50%;
        border: solid;
        background: #6cc1e3;'>Volver</a>";
}