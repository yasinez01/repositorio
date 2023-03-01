<?php 
/*
Vamos a realizar un formulario donde vamos a pedir los datos de una persona: Nombre, Primer apellido, Segundo apellido, Dirección, 
Población, Provincia, Teléfono1, Teléfono2, email.
Posteriormente al darle a enviar, mostraremos una tabla con todos los datos de esta persona.
*/
//datos primer jugador
$nombre1= $_GET["nombre1"];
$primer_apellido1 = $_GET["primer_apellido1"];
$segundo_apellido1= $_GET["segundo_apellido1"];
$direccion1=$_GET["Direccion1"];
$poblacion1=$_GET["Poblacion1"];
$telefono11=$_GET["Telefono11"];
$telefono21=$_GET["Telefono21"];
$email1=$_GET["Email1"];
//datos segundo jugador
$nombre2= $_GET["nombre2"];
$primer_apellido2 = $_GET["primer_apellido2"];
$segundo_apellido2= $_GET["segundo_apellido2"];
$direccion2=$_GET["Direccion2"];
$poblacion2=$_GET["Poblacion2"];
$telefono12=$_GET["Telefono12"];
$telefono22=$_GET["Telefono22"];
$email2=$_GET["Email2"];
//iteracciones
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
        if($i%2==0){
            echo "<td>".$nombre1."</td>";
            echo "<td>".$primer_apellido1."</td>";
            echo "<td>".$segundo_apellido1."</td>";
            echo "<td>".$direccion1."</td>";
            echo "<td>".$poblacion1."</td>";
            echo "<td>".$telefono11."</td>";
            echo "<td>".$telefono21."</td>";
            echo "<td>".$email1."</td>";    
            echo"</tr>";
        }else{
            echo "<td>".$nombre2."</td>";
            echo "<td>".$primer_apellido2."</td>";
            echo "<td>".$segundo_apellido2."</td>";
            echo "<td>".$direccion2."</td>";
            echo "<td>".$poblacion2."</td>";
            echo "<td>".$telefono12."</td>";
            echo "<td>".$telefono22."</td>";
            echo "<td>".$email2."</td>";    
            echo"</tr>";
        }   
        
    }
echo"</table>";
?>