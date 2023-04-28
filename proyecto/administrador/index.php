<?php 
    include "basededatos.php";
	include "modelo.php";
	include "vista.php";
	if (isset($_GET['accion'])) {
		$accion = $_GET['accion'];
	} else {
		if (isset($_POST['accion'])) {
			$accion = $_POST['accion'];
		} else {
			$accion = "menu";
		}
	}
	if ($accion == "menu") {
		vmostrarmenuprincipal();
	}
    else if($accion=="altausuario"){
        vmostrarresultadoalta(mvalidaraltausuario($con));
    }else if($accion=="listado"){
		vmostrarlistadousuarios(mlistadousuario($con));
	}else if($accion=="modificar"){
		vmostrarusuario(mdatosusuario($con));
	}else if($accion=="validarmodificacion"){
		vmostrarresultadomodificacion(mvalidarmodificarusuario($con));
	}else if($accion=="eliminar"){
		vmostraresultadoeliminacion(meliminarusuario($con));
	}
?>