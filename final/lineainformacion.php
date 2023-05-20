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
    $respuesta=$Consulta->realizarconsulta($url_calendario,'GET');
    $datos = json_decode($respuesta);
        if(substr($datos->{'description'}, 0, 13)=== "NO data found"){
            echo'<script type="text/javascript">
                alert("NO data found, prueba con otros valores");
                window.location.href="paradasalrededor.html";
                </script>';
        }else{
            $tipodia=$datos->{'data'}[0]->{'dayType'};
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
        <link rel="stylesheet" href="datoslineainformacion.css" > 
    </head>
    <body class="contenido">
        <?php
        echo "<div id=informacion_lineas>";
        echo "<t1 id=tituloLineas>Lineas</t1>";
        if($emptyopcion2){
            for($i=0;$i<sizeof($datos->{'data'});$i++){
                echo "<table>";
                echo "<tr><th colspan=3>".$datos->{'data'}[$i]->{'dateRef'}."</th></tr>";
                echo "<tr><td class=primeraColumna>Linea</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'line'}."</td></tr>";
                echo "<tr><td class=primeraColumna>DESDE</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'nameA'}."</td></tr>";
                echo "<tr><td class=primeraColumna>HASTA</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'nameB'}."</td></tr>";
                for($j=0; $j<sizeof($datos->{'data'}[$i]->{'timeTable'}); $j++)
                    if($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}==$tipodia){
                        if($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="LA") echo "<tr><td class=primeraColumna>Tipo de día</td><td class=segundaColumna>Día laborable</td></tr>";
                        elseif($datos->{'data'}[$i]->{'timeTable'}[$j]->{'idDayType'}=="SA") echo "<tr><td class=primeraColumna>Tipo de día</td><td class=segundaColumna>Sábado</td></tr>";
                        else echo "<tr><td class=primeraColumna>Tipo de día</td><td class=segundaColumna>Día festivo</td></tr>";
                        echo "<tr><td class=columnaDireccion colspan=3>Direccion 1:</td><tr>";
                        echo "<tr><td class=primeraColumna>Hora Inicio</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'StartTime'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Hora Fin</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'StopTime'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Minima Frecuencia de minutos de espera</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'MinimunFrequency'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Máxima Frecuencia de minutos de espera</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction1'}->{'MaximumFrequency'}."</td><tr>";
                        echo "<tr><td class=columnaDireccion colspan=3>Direccion 2:"."</td><tr>";
                        echo "<tr><td class=primeraColumna>Hora Inicio</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'StartTime'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Hora Fin</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'StopTime'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Minima Frecuencia de minutos de espera</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'MinimunFrequency'}."</td><tr>";
                        echo "<tr><td class=primeraColumna>Máxima Frecuencia de minutos de espera</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'timeTable'}[$j]->{'Direction2'}->{'MaximumFrequency'}."</td><tr>";
                        echo "</table>";
                    }
            }
            if(isset($_SESSION['usuarioregistrado'])){
                ?>
                <form action="csv.php" method="post" target="_blank">
                    <input type="hidden" name="seccion" value="informacionlinea">
                    <input type="hidden" name="linea" value="<?php echo $numerolinea ?>">
                    <input type="hidden" name="fecha" value="<?php echo $fecha1 ?>">
                    <input class="botoncsv" type="submit" value="Descargar CSV">
                </form>
                <?php
                }
        }else{
            for($i=0; $i<sizeof($datos->{'data'}); $i++){
                echo "<table>";
                echo "<tr><td class=primeraColumna>Linea</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'line'}."</td><tr>";
                echo "<tr><td class=primeraColumna>Grupo</td><td class=segundaColumna>".$datos->{'data'}[$i]->{'group'}."</td><tr>";
                echo "</table>";
            }
            if(isset($_SESSION['usuarioregistrado'])){
                ?>
                <form action="csv.php" method="post" target="_blank">
                    <input type="hidden" name="seccion" value="informacionlineas">
                    <input type="hidden" name="fecha" value="<?php echo $fecha2 ?>">
                    <input class="botoncsv" type="submit" value="Descargar CSV">
                </form>
                <?php
                }
        }
        echo "</div>";

        echo"<a id=volver href='lineainformacion.html'>Volver</a>";
        ?>
    </body>
<?php
}