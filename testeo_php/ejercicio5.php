<?php
/*Hacer un ejercicio igual que el número 4. 
Pero en esta ocasión queremos que las filas pares tengan un color de fondo de las celdas diferente a las de las impares. */
echo "<table>";
$total = 0;
for ($i = 1; $i <= 50; $i++) {
  $total += $i;
  // Verifica si la fila es par o impar y establece un color de fondo diferente
  $color = ($i % 2 == 0) ? "red" : "blue";    //condición ? valor_si_verdadero : valor_si_falso;
  echo "<tr style='background-color: " . $color . ";'><td>" . $i . "</td><td>Ejercicio número 3</td><td>" . $total . "</td></tr>";
}
echo "</table>";

/* #ddd es gris claro y #fff es blanco */