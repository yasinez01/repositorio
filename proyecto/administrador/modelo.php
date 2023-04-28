<?php 
	include "basededatos.php";
	function mvalidaraltausuario($conexion) {
		$user = $_POST['usuario'];
		$pass = $_POST['password'];
		$admin = $_POST['administrador'];
		$consulta = "insert into db_grupo28.usuario (usuario, password, administrador) values ('$user', '$pass', '$admin')";
		if ($conexion->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}
	function mlistadousuario($con) {
		$consulta = "Select * from db_grupo28.usuario";
		if ($resultado = $con->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}
	function mdatosusuario($con) {
		$idpersona = $_GET['idpersona'];
		$consulta = "select * from db_grupo28.usuario where id = $idpersona";
		if ($resultado = $con->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}
	function mvalidarmodificarusuario($con) {
		$user = $_POST['usuario'];
		$pass = $_POST['password'];
		$admin = $_POST['administrador'];
		$id = $_POST['idusuario'];
		$consulta = "update db_grupo28.usuario set usuario='$user', password='$pass', administrador='$admin' where id = $id";
		if ($con->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}
	function meliminarusuario($con){
		$idpersona = $_GET['idpersona'];
		$consulta = "delete from db_grupo28.usuario where id = $idpersona";
		if ($con->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}

?>







