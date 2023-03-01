<?php
/*En este programa vamos a realizar una función a la cual le pasamos dos números y nos tiene que devolver la suma de ambos.
Creamos 2 arrays de 20 números cualesquiera. Posteriormente vamos a hacer una lista numerada donde colocaremos en cada 
posición de la lista la suma de los elementos de los dos arrays que están en la posición correspondiente.*/

// Definimos una función que recibe dos números y devuelve su suma
function sumar($num1, $num2) {
    return $num1 + $num2;
  }
  
  // Creamos dos arrays de 20 números cada uno
  $array1 = array(1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20);
  $array2 = array(20, 18, 16, 14, 12, 10, 8, 6, 4, 2, 19, 17, 15, 13, 11, 9, 7, 5, 3, 1);
  
  // Creamos una lista numerada donde cada elemento es la suma de los elementos de los arrays correspondientes
  echo "<ol>";   //ol para lista ordenada
  for ($i = 0; $i < count($array1); $i++) {
    $suma = sumar($array1[$i], $array2[$i]);
    echo "<li>" . $suma . "</li>";
  }
  echo "</ol>";
  ?>