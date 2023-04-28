<?php 

	function vmostrarmenuprincipal() {
		echo file_get_contents("menu.html");
	}
    function vmostrarmensaje($titulo, $texto) {
		$pagina = file_get_contents("mensaje.html");
		$pagina = str_replace("##titulo##", $titulo, $pagina);
		$pagina = str_replace("##texto##", $texto, $pagina);
		echo $pagina;		
	}
    function vmostrarresultadoalta($resultado) {
		$mensaje = "";
		if ($resultado == 1) {
			$mensaje = "La persona se ha dado de alta correctamente.";
		} else {
			$mensaje = "No se ha podido añadir la persona. Vuelva a intentarlo. Si el problema persiste póngase en contacto con el administrador";
		}
		vmostrarmensaje("Alta de persona", $mensaje);
	}
	function vmostrarlistadousuarios($resultado) {
		$pagina = file_get_contents("listadousuarios.html");
		if (!is_object($resultado)) {
			vmostrarmensaje("Listado de personas", "Se ha producido un error en el sistema. Vuelva a intentarlo. Y si el problema persiste póngase en contacto con el administrador.");		
		} else {
			$trozos = explode("##fila##", $pagina);
			$centro = "";
			while ($datos = $resultado->fetch_assoc()) {
				$aux = $trozos[1];
				$aux = str_replace("##idpersona##", $datos['id'], $aux);
				$aux = str_replace("##usuario##", $datos['usuario'], $aux);
				$aux = str_replace("##password##", $datos['password'], $aux);
				if($datos['administrador']==0){
					$aux = str_replace("##admin##", "No es administrador", $aux);	
				}else{
					$aux = str_replace("##admin##", "Es administrador", $aux);
				}
				$centro .= $aux;
			}
			echo $trozos[0] . $centro . $trozos[2];
		}
	}
	function vmostrarusuario($resultado){
		if (!is_object($resultado)) {
			vmostrarmensaje("Modificación de personas", "Se ha producido un error en el sistema. Vuelva a intentarlo. Y si el problema persiste póngase en contacto con el administrador.");				
		} else {
			$datos = $resultado->fetch_assoc();
			$aux = file_get_contents("modificar.html");	
			$aux = str_replace("##idusuario##", $datos['id'], $aux);
			$aux = str_replace("##usuario##", $datos['usuario'], $aux);
			$aux = str_replace("##password##", $datos['password'], $aux);
			echo $aux;
		}
	}
	function vmostrarresultadomodificacion($resultado) {
		$mensaje = "";
		if ($resultado == 1) {
			$mensaje = "La persona se ha modificado correctamente.";
		} else {
			$mensaje = "No se ha podido modificar la persona. Vuelva a intentarlo. Si el problema persiste póngase en contacto con el administrador";
		}
		vmostrarmensaje("Modificación de persona", $mensaje);		
	}
	function vmostraresultadoeliminacion($resultado){
		$mensaje = "";
		if ($resultado == 1) {
			$mensaje = "La persona se ha eliminado correctamente.";
		} else {
			$mensaje = "No se ha podido eliminar la persona. Vuelva a intentarlo. Si el problema persiste póngase en contacto con el administrador";
		}
		vmostrarmensaje("Eliminación de persona", $mensaje);		
	}


?>







