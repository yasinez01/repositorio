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
}else{?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="datoscalendario.css" > 
    </head>
    <body class="contenido">
        <?php
        echo "<div id=informacion_dias>";
        echo "<t1 id=tituloCalendario>Calendario</t1>";
        for($i=0;$i<sizeof($datos->{'data'});$i++){
            $dia= explode(" ",$datos->{'data'}[$i]->{'date'});
            echo "<table class='fila'>";
            echo "<tr><th colspan=3>".$dia[0]."</th></tr>";
            if($datos->{'data'}[$i]->{'strike'} == "N") echo "<tr><td class=primeraColumna>Huelga</td> <td class=segundaColumna>NO</td></tr>";
            else echo "<tr><td class=primeraColumna>Huelga</td> <td class=segundaColumna>SI</td></tr>";
            if($datos->{'data'}[$i]->{'dayType'}=="LA") echo "<tr><td class=primeraColumna>Tipo de día</td> <td class=segundaColumna>Día laborable</td></tr>";
            elseif($datos->{'data'}[$i]->{'dayType'}=="SA") echo "<tr><td class=primeraColumna>Tipo de día</td> <td class=segundaColumna>Sábado</td></tr>";
            else echo "<tr><td class=primeraColumna>Tipo de día </td> <td class=segundaColumna>Día festivo</td></tr>";
            echo "</table>";
        }
        echo "</div>";
        if(isset($_SESSION['usuarioregistrado'])){
            ?>
            <form action="csv.php" method="post" target="_blank">
                <input type="hidden" name="seccion" value="calendario">
                <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
                <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
                <input type="submit" value="Click para generar CSV Ida">
            </form>
            <?php
            }
        echo"<a id=volver href='calendario.html'>Volver</a>";
        ?>
    </body>
<?php
}