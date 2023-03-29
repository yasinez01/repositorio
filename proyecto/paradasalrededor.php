<?php
session_start();
$curl = curl_init();
$numeroparada = $_GET["parada"];
$metros=$_GET["metros"];
$longitud=$_GET["longitud"];
$latitud=$_GET["latitud"];
$radio=$_GET["radio"];
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
    'accessToken: '. $_SESSION['accessToken'],
    'Cookie: SERVERIDP=b45a524a27860afec772689f834014cb22bcb504'
    ),
));
     
$response = curl_exec($curl);
$datos=json_decode($response);
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
curl_close($curl);