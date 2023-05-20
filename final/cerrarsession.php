<?php
    session_start();
    unset($_SESSION['usuarioregistrado']);
    header("location:web.php");
?>
