<?php
/* Vamos a crear una función que recibe 2 parámetros. El primero indica el número de filas y el segundo indica la frase a escribir.
Esta función lo que hace es escribir en pantalla una tabla en formato html con el número de filas indicadas llenas de la frase que 
se ha pasado como segundo parámetro.*/

// Función que genera una tabla con el número de filas y la frase especificados
function generarTabla($filas, $frase) {
  // Iniciamos la tabla
  echo "<table border=1>";
  // Generamos cada fila
  for ($i = 1; $i <= $filas; $i++) {
    echo "<tr>";                                //fila -> <tr>
    // En cada celda colocamos la frase
      echo "<td>" . $frase . "</td>";           //columna -> <td>
    echo "</tr>";
  }
  // Cerramos la tabla
  echo "</table>";
}

// Ejemplo de uso
generarTabla(5, "Hola mundo!");

