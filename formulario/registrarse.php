<?php
    session_start();
    //$_SESSION['usuario']= /*usuario */
    //header("Location:");
    //error_reporting(0); hace q no aparezcan los errores en la pagina
    //die(); mata el proceso
    //session_destroy(); cerrar session, debajo se debe poner header();
    //mysqli_num_rows($consulta); devuelve el numero de filas de resultado 
    // q tiene esa consulta sql
    // mysqli_free_result($consulta) libera los resultados obtenidos de la consulta
    
    $usuario=$_GET["username"];
    $pass=$_GET["password"];
    $conexion=mysql_connect("dbserver","grupo28","ahX9Zeelei","db_grupo28");
    //$consulta="CREATE TABLE USUARIOS(user varchar(255),pass varchar(255))";
    $consulta="SELECT * FROM USUARIO WHERE USUARIO='$usuario' and clave='$pass'";
    $resultado=mysql_query($conexion,$consulta);
    $filas=mysql_num_rowa($resultado);
    if($filas>0){
        header("location:bienvenidos.html");
    }else{
        echo "Error en la autentificación";
    }
    mysql_free_result($resultado);
    mysql_close($conexion);
?>
  