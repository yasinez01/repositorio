<?php
require 'Consulta.php';
error_reporting(0);
session_start();
$curl = curl_init();
$numeroparada = $_GET["parada"];
$metros=$_GET["metros"];
$longitud=$_GET["longitud"];
$latitud=$_GET["latitud"];
$radio=$_GET["radio"];
$Consulta = new Consulta();
$AllEmpty=empty($numeroparada) && empty($metros) && empty($longitud) && empty($latitud) && empty($radio);
$NoneEmpty=!empty($numeroparada) && !empty($metros) && !empty($longitud) && !empty($latitud) && !empty($radio);
$EmptyOpcion1=empty($numeroparada) && empty($metros);
$notallopcion1=empty($numeroparada) || empty($metros);
$emptyopcion2=empty($longitud) && empty($latitud) && empty($radio);
$notallopcion2=empty($longitud) || empty($latitud) || empty($radio);
if($AllEmpty) {
    echo'<script type="text/javascript">
      alert("Es obligatorio rellenar todos los campos de la opción que desea.");
        window.location.href="paradasalrededor.html";
        </script>'; 
}else if($NoneEmpty) {
    echo'<script type="text/javascript">
      alert("Es obligatorio rellenar solo los campos de una opción.");
        window.location.href="paradasalrededor.html";
        </script>';
}else{
    if($EmptyOpcion1){
        if($notallopcion2){
            echo'<script type="text/javascript">
            alert("Es obligatorio rellenar todos los campos de una opción.");
            window.location.href="paradasalrededor.html";
            </script>';
        }else{
            $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundxy/'. $longitud.'/'. $latitud .'/'.$radio.'/';
        }
    }else{
            if($notallopcion1){
                echo'<script type="text/javascript">
                alert("Es obligatorio rellenar todos los campos de una opción.");
                window.location.href="paradasalrededor.html";
                </script>';
            }else{
                if(!$emptyopcion2){
                    echo'<script type="text/javascript">
                    alert("Es obligatorio rellenar solo los campos de una opción.");
                    window.location.href="paradasalrededor.html";
                    </script>';
                }else{
                    $url='https://openapi.emtmadrid.es/v2/transport/busemtmad/stops/arroundstop/'.$numeroparada.'/'.$metros.'/';
                } 
            } 
    }
}
$datos=$Consulta->realizarconsulta($url,'GET');
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
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
    echo"<a href='paradasalrededor.html' style='text-decoration: none;
        color: blue;
        margin-left: 50%;
        border: solid;
        background: #6cc1e3;'>Volver</a>";
}