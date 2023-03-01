<?php
/*Vamos a construir una tabla con 50 filas. 
Esta tabla tendrá 2 columnas.
 La primera de ellas tendrá el número de la fila. Y la segunda contendrá el mensaje:  Ejercicio número 3 */
 
echo "<table border=1>";
for ($i = 1; $i <= 50; $i++) {
  echo "<tr><td>" . $i . "</td><td>Ejercicio número 3</td></tr>";    //tr indica el inicio de una fila, td indican que son dos columnas
}
echo "</table>";

//fila -> <tr>
//columna -> <td>