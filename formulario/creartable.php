<?php
    $conexion=mysqli_connect("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    //$consulta="CREATE TABLE USUARIOS(user varchar(255),pass varchar(255))";
    $consulta="SELECT * FROM db_grupo28.usuario";
    $resultado=mysqli_query($conexion,$consulta);
    $filas=mysqli_num_rows($resultado);
    if($filas>0){
        echo "Tenemos datos";
        //header("location:login.html");
    }else{
        echo "Error en la autentificación";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
?>
  