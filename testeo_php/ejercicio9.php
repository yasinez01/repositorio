<?php
/*Vamos a hacer un ejercicio que haga un include del ejercicio anterior. 
De forma que ahora llamaremos dentro de nuestro documento 3 veces a la función del ejercicio anterior con diferentes parámetros. 
Así veremos cómo construimos un html formado a través de una función en php.*/ 

include 'ejercicio8.php';

// Llamamos a la función 3 veces con diferentes parámetros
generarTabla(2, "Hola");
generarTabla(4, "como estas");
generarTabla(6, "bien");