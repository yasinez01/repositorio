<?php 
/*
Vamos a realizar un formulario donde vamos a pedir los datos de una persona: Nombre, Primer apellido, Segundo apellido, Dirección, 
Población, Provincia, Teléfono1, Teléfono2, email.
Posteriormente al darle a enviar, mostraremos una tabla con todos los datos de esta persona.
*/
$nombre= $_GET["nombre"];
$primer_apellido = $_GET["primer_apellido"];
$segundo_apellido= $_GET["segundo_apellido"];
$direccion=$_GET["Direccion"];
$poblacion=$_GET["Poblacion"];
$telefono1=$_GET["Telefono1"];
$telefono2=$_GET["Telefono2"];
$email=$_GET["Email"];
$iterraciones=$_GET["iterraciones"];
echo "<table border =1>";
    echo "<tr>";
    echo "<td>Nombre</td>";
    echo "<td>Primer_Apellido</td>";
    echo "<td>Segundo_Apellido</td>";
    echo "<td>Direccion</td>";
    echo "<td>Poblacion</td>";
    echo "<td>Telefono1</td>";
    echo "<td>Telefono2</td>";
    echo "<td>Email</td>";
    echo "</tr>";
    for($i=1;$i<=$iterraciones;$i++){
        echo"<tr>";
        echo "<td>".$nombre."</td>";
        echo "<td>".$primer_apellido."</td>";
        echo "<td>".$segundo_apellido."</td>";
        echo "<td>".$direccion."</td>";
        echo "<td>".$poblacion."</td>";
        echo "<td>".$telefono1."</td>";
        echo "<td>".$telefono2."</td>";
        echo "<td>".$email."</td>";
        echo"</tr>";
    }
echo"</table>";
?>