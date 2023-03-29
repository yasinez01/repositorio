<?php
 require 'Conexion.php';
    session_start();
    $usuario = $_GET["nombre"];
    $pass=$_GET["password"];
    /*$conexion=mysqli_connect("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    $consulta="SELECT * FROM db_grupo28.usuario WHERE usuario='$usuario' and password='$pass'";
    $resultado=mysqli_query($conexion,$consulta);
    if(mysqli_num_rows($resultado) > 0){
        header("location:web.html");
    }else{
        echo'<script type="text/javascript">
        alert("Autentificacion fallida");
        window.location.href="loginregister.html";
        </script>';
    }
    */
    $Coneccion= new Conexion("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    $comprobarusuario=$Coneccion->validarUsuario($usuario,$pass);
    $Coneccion->cerrarSession();
    if($comprobarusuario==1){
        header("location:web.html");
    }else{
        echo'<script type="text/javascript">
        alert("Autentificacion fallida");
        window.location.href="loginregister.html";
        </script>';
    }
    //mysqli_close($conexion);
?>
 