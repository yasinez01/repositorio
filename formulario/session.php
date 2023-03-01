<?php
    session_start();
    $_SESSION['usuario']= /*usuario */
    header("Location:");
    //error_reporting(0); hace q no aparezcan los errores en la pagina
    //die(); mata el proceso
    //session_destroy(); cerrar session, debajo se debe poner header();
    //mysqli_num_rows($consulta); devuelve el numero de filas de resultado 
    // q tiene esa consulta sql
    // mysqli_free_result($consulta) libera los resultados obtenidos de la consulta
    /*
    $usuario=$_POST['usuario'];
    $Clave=$_POST['clave'];
    $conexion=mysql_connect("localhost","root","","slkdjf");
    $consulta="SELECT * FROM USUARIO WHERE USUARIO='$usuario' and clave='$Clave'";
    $resultado=mysql_query($conexion,$consulta);
    $filas=mysql_num_rowa($resultado);
    if($filas>0){
        header("location:bienvenidos.html");
    }else{
        echo "Error en la autentificación";
    }
    mysql_free_result($resultado);
    mysql_close($conexion);
    */

?>