<?php
    $conexion=mysqli_connect("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    //$consulta="CREATE TABLE USUARIOS(user varchar(255),pass varchar(255),administrador varchar(255))";
    $usuario='julen';
    $pass=$usuario;
    $consulta="SELECT administrador FROM db_grupo28.usuario where  usuario='$usuario' and password='$pass'";
    $resultado=mysqli_query($conexion,$consulta);
    $filas=mysqli_num_rows($resultado);
    if($filas>0){
        while($dato = mysqli_fetch_array($resultado)){echo ($dato['administrador']+1);}
    }else{
        echo "Error en la autentificación";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
?>
  