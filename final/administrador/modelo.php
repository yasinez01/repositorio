<?php 
	session_start();
	include "basededatos.php";
	function mvalidaraltausuario($conexion) {
		$user = $_POST['usuario'];
		$pass = $_POST['password'];
		$admin = $_POST['administrador'];
		$consulta = "insert into db_grupo28.final_usuario (usuario, password, administrador) values ('$user', '$pass', '$admin')";
		if ($conexion->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}
	function mlistadousuario($con) {
		$consulta = "Select * from db_grupo28.final_usuario";
		if ($resultado = $con->query($consulta)) {
			return $resultado;
		} else {
			return -1;
		}
	}
	function mdatosusuario($con) {
		$idpersona = $_GET['idpersona'];
		$consulta = "select * from db_grupo28.final_usuario where id = $idpersona";
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
		$consulta = "update db_grupo28.final_usuario set usuario='$user', password='$pass', administrador='$admin' where id = $id";
		if ($con->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}
	function meliminarusuario($con){
		$idpersona = $_GET['idpersona'];
		$consulta = "delete from db_grupo28.final_usuario where id = $idpersona";
		if ($con->query($consulta)) {
			return 1;
		} else {
			return -1;
		}
	}
	// PHP
  if (isset($_GET['action'])){
    $mysqli = new mysqli("dbserver", "grupo28", "Fi0ci3eiy9", "db_grupo28");
    $result = $mysqli->query("SELECT administrador FROM db_grupo28.final_usuario");
    $adminCount = 0;
    $totalCount = $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        if ($row["administrador"] == 1) {
            $adminCount++;
        }
    }
    $adminPercentage = ($adminCount / $totalCount) * 100;
    $nonAdminPercentage = 100 - $adminPercentage;
    $data = array(
        "adminPercentage" => $adminPercentage,
        "nonAdminPercentage" => $nonAdminPercentage
    );
    $mysqli->close();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }
?>