<?php
$mensaje1 = "Hola mundo!!!";
$mensaje2 = "Bienvenidos al php!!!";

for ($i = 1; $i <= 10; $i++) {
  echo ($i % 2 == 0) ? $mensaje2 . "<br>" : $mensaje1 . "<br>";   //condición ? valor_si_verdadero : valor_si_falso;
}
