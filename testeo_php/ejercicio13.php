<?php 
/*
Vamos a realizar un ejercicio igual que el 12. Pero en esta ocasión la información vendrá dada a 
partir de un formulario. En el formulario pediremos el número de filas y el texto.
Y además tendremos 2 listas desplegables para elegir el color 1 y color2.
*/
$numerofilas= $_GET["numerofilas"];
$texto = $_GET["texto"];
$color1=['red',  'green',  'blue',  'Brown',  'gray',  'yellow','orange','white'];
$color2=['red',  'green',  'blue',  'Brown',  'gray',  'yellow','orange','white'];
echo "<table border =1>";
for ($i = 1; $i <= $numerofilas; $i++) {
    echo "<tr>";
    echo "<td>".$i."</td>";
    if($i<count($color1)){
        echo ($i %2 == 0) ? "<td style='background-color: " . $color1[$i] . ";'>".$texto."</td>": "<td style='background-color: " . $color2[$i] . ";'>".$texto."</td>";
    }else{
        echo ($i %2 == 0) ? "<td style='background-color: " . $color1[$i%count($color1)] . ";'>".$texto."</td>": "<td style='background-color: " . $color1[$i%count($color1)] . ";'>".$texto."</td>";
    }
    echo "</tr>";
}
echo"</table>";
?>