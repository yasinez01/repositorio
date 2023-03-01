<?php
/*Vamos a realizar un ejercicio en php que va a recibir como parámetro por la URL un número. Este número lo vamos a utilizar para crear una tabla con el número de filas indicado en el parámetro y 
dentro de cada fila colocaremos el mensaje “Hola mundo!!!!”. Además en una segunda columna de la tabla indicaremos el número de fila.*/

// Obtenemos el valor del parámetro "num" pasado por la URL
$num_filas = $_GET['numero'];   // $_GET para obtener el valor del parámetro pasado por la URL

// Creamos la tabla
echo "<table border=2>";
// Creamos las filas de la tabla con un bucle for
for ($i = 1; $i <= $num_filas; $i++) {
  // Creamos una fila de la tabla
  echo "<tr>";

  // Creamos la primera celda con el mensaje "Hola mundo!!!!"
  echo "<td>Hola mundo!!!!</td>";

  // Creamos la segunda celda con el número de fila
  echo "<td>" . $i . "</td>";

  // Cerramos la fila de la tabla
  echo "</tr>";
}

// Cerramos la tabla
echo "</table>";
?>