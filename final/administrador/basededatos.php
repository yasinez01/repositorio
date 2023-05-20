<?php 

	$servidor = "dbserver";
	$usuario = "grupo28";
	$password = "Fi0ci3eiy9";
	$basededatos = "db_grupo28";
	$con = mysqli_connect($servidor, $usuario, $password, $basededatos);

	if (!$con) {
		die ("Conexión fallida: " . mysqli_connect_error());
	}

?>