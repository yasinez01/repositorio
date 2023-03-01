<?php
/*Vamos a realizar un ejercicio que va a recibir por la URL 4 parámetros.
1.- Número de líneas
2.- Texto a incluir en cada línea
3.- Color 1 de fondo
4.- Color 2 de fondo
(Los colores permitidos serán:  red,  green,  blue,  Brown,  gray,  yellow).
Crearemos una tabla con 2 columnas. En la primera columna pondremos el número de fila. Y en la segunda columna pondremos el texto indicado en el parámetro texto. Posteriormente de forma alternada pondremos el fondo del color indicado en los parámetros color1 y color2.
En el caso de que los colores indicados no existan, utilizaremos los colores: naranja (para color1) y blanco (para color2)*/
$numero_lineas= $_GET['numero_lineas'];
$texto=$_GET['texto'];
$color1=$_GET['color1'];
$color2=$_GET['color2'];
if($color1 != 'red' && $color1!='green' && $color1!='blue' && $color1!='brown' && $color1!='gray' && $color1!='yellow'){
    $color1="orange";
    $color2="white";
}
if($color2 != 'red' && $color2!='green' && $color2!='blue' && $color2!='brown' && $color2!='gray' && $color2!='yellow'){
    $color1="orange";
    $color2="white";
}
echo "<table border =1>";
for ($i = 1; $i <= $numero_lineas; $i++) {
    echo "<tr>";
    echo "<td>".$i."</td>";
    echo ($i %2 == 0) ? "<td style='background-color: " . $color1 . ";'>".$texto."</td>": "<td style='background-color: " . $color2 . ";'>".$texto."</td>";
    echo "</tr>";
}
echo"</table>";

