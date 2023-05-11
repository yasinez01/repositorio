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
$respuesta=$Consulta->realizarconsulta($url,'GET');
$datos = json_decode($respuesta);
if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
    echo'<script type="text/javascript">
        alert("NO data found, prueba con otros valores");
        window.location.href="paradasalrededor.html";
        </script>';
}else{?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="datosparadasalrededor.css" > 
    </head>
    <body class="contenido">
        <?php
        echo "<div id=informacion_paradas>";
        echo "<t1 id=tituloParadasAlrededor>PARADAS ALREDEDOR</t1>";
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            echo "<table class='fila'>";
            echo "<tr><th colspan=3>Parada ".$datos->{'data'}[$i]->{'stopId'}."</th></tr>";
            echo "<tr><td class=primeraColumna>Coordenada (Latitud)</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'geometry'}->{"coordinates"}[0]."</td></tr>";
            echo "<tr><td class=primeraColumna>Coordenada (Longitud)</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'geometry'}->{"coordinates"}[1]."</td></tr>";
            echo "<tr><td class=primeraColumna>Nombre</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'stopName'}."</td></tr>";
            echo "<tr><td class=primeraColumna>Direccion</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'address'}."</td></tr>";
            echo "<tr><td class=primeraColumna>Lineas</td><td class=segundaColumna>";
            for($j=0;$j<sizeof($datos->{'data'}[$i]->{'lines'});$j++){
                echo $datos->{'data'}[$i]->{'lines'}[$j]->{"line"};
                if($j < sizeof($datos->{'data'}[$i]->{'lines'}) - 1){
                    echo ", ";
                }
            }
            echo "</td></tr></table>";
        }
        if(isset($_SESSION['usuarioregistrado'])){
        ?>
        <form action="csv.php" method="post" target="_blank">
            <?php 
                if(empty($longitud)){
                    ?>
                    <input type="hidden" name="seccion" value="paradasalrededorconnumero">
                    <input type="hidden" name="numeroparada" value="<?php echo $numeroparada ?>">
                    <input type="hidden" name="metros" value="<?php echo $metros ?>">
                    <?php
                }else{
                    ?>
                    <input type="hidden" name="seccion" value="paradasalrededorconlongitudylatitud">
                    <input type="hidden" name="longitud" value="<?php echo $longitud ?>">
                    <input type="hidden" name="latitud" value="<?php echo $latitud ?>">
                    <input type="hidden" name="radio" value="<?php echo $radio ?>">
                    <?php
                }
            ?>
            <input type="submit" value="Click para generar CSV">
        </form>
        <?php
        }
        echo "</div><br><br><br><br>";
        echo"<a id='volver' href='paradasalrededor.html'>Volver</a>";
        ?>
    </body>
    </html>
<?php
}