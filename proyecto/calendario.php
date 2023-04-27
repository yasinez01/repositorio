<?php
require 'Consulta.php';
error_reporting(0);
session_start();
$Consulta = new Consulta();
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
$respuesta=$Consulta->realizarconsulta($url,'GET');
$datos = json_decode($respuesta);
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
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
    echo"<a href='calendario.html' style='text-decoration: none;
        color: blue;
        margin-left: 50%;
        border: solid;
        background: #6cc1e3;'>Volver</a>";
}