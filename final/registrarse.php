<?php
    require 'Conexion.php';
    session_start();
    $usuario=$_GET["nombre2"];
    $pass=$_GET["password2"];
    $Coneccion= new Conexion("dbserver","grupo28","Fi0ci3eiy9","db_grupo28");
    $Coneccion->RegistrarUsuario($usuario,$pass);
    $_SESSION['nombreusuario']=$usuario;
    $_SESSION['usuarioregistrado']=true;
    $Coneccion->cerrarSession();
    header("location:web.php");
?>