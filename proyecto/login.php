<?php
    $usuario = $_GET["text"];
    $pass=$_GET["password"];
    $conexion=mysqli_connect("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    $consulta="SELECT * FROM db_grupo28.usuario WHERE usuario='$usuario' and password='$pass'";
    $resultado=mysqli_query($conexion,$consulta);
    if(mysqli_num_rows($resultado) > 0){
        header("location:lista.php");
    }else{
        echo'<script type="text/javascript">
        alert("Autentificacion fallida");
        window.location.href="login.html";
        </script>';
    }
    mysqli_close($conexion);
?>
 