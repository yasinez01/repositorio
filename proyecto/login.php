<?php
 require 'Conexion.php';
    session_start();
    $usuario = $_GET["nombre"];
    $pass=$_GET["password"];
    $Coneccion= new Conexion("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    $comprobarusuario=$Coneccion->validarUsuario($usuario,$pass);
    $Coneccion->cerrarSession();
    if($comprobarusuario==1){
        $_SESSION['nombreusuario']=$usuario;
        $_SESSION['usuarioregistrado']=true;
        header("location:web.php");
    }else{
        echo'<script type="text/javascript">
        alert("Autentificacion fallida");
        window.location.href="loginregister.html";
        </script>';
    }
    //mysqli_close($conexion);
?>
 