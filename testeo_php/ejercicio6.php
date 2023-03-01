
<?php
/*En este ejercicio vamos a crear un array con 20 números (los que nosotros queramos). 
Posteriormente vamos a construir una lista numerada. Donde en cada posición de la lista colocaremos el número correspondiente de la posición del array. */
$numeros = array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40);
echo "<ol>";
for($i = 0; $i < 20; $i++) {
  echo "<li>".$numeros[$i] ."</li>";
}
echo "<ol>";

//<ol> para iniciar y finalizar la lista numerada
// foreach para recorrer los elementos del array $numeros
// la variable $key tendrá valores de 0 a 19, que corresponden a las posiciones del array
//$value: Esta variable representa el valor del elemento en el array. En este caso, los valores son los números que queremos mostrar en la lista.
//<li> se utiliza dentro de las etiquetas <ol> (listas ordenadas) o <ul> (listas no ordenadas) para representar cada uno de los elementos de la lista.
