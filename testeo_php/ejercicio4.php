<?php
/*Vamos a realizar un ejercicio igual que el número 3. 
Pero en esta ocasión colocaremos una tercera columna que sea total. Esta columna irá sumando todo el tiempo el número de filas. Así en la primera fila será:  1
La segunda fila será:  3  (como resultado de la fila 1 + la fila 2)
La tercera fila será :  6 (como resultado de la fila 1 + la fila 2 + la fila 3)
Y así sucesivamente hasta la fila 50.*/
echo "<table border=1>";
$total = 0;
for ($i = 1; $i <= 50; $i++) {
  $total += $i;
  echo "<tr><td>" . $i . "</td><td>Ejercicio número 3</td><td>" . $total . "</td></tr>";
}
echo "</table>";