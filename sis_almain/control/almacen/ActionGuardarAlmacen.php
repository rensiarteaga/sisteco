<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarAlmacen.php
 * Propósito:				Permite insertar y modificar datos en la tal_almacen
 * Tabla:					tal_almacen
 * Parámetros:				$id_almacen
 * $id_lugar
 * $id_depto
 * $codigo
 * $nombre
 * $direccion
 * $estado
 * $tipo_control
 *
 * Valores de Retorno: Número de registros guardados
 * Fecha de Creación:		25-07-2013 12:24:45
 * Versión:				1.0.0
 * Autor:					Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarAlmacen.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		
		// Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		// valores permitidos de $cod -> "si", "no"
		switch ($cod) {
			case "si" :
				$decodificar = true;
				break;
			case "no" :
				$decodificar = false;
				break;
			default :
				$decodificar = true;
				break;
		}
	} elseif (sizeof($_POST) > 0) {
		$get = false;
		$cont = $_POST["cantidad_ids"];
		
		// Por Post siempre se decodifica
		$decodificar = true;
	} else {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	}
	
	// Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	
	// Realiza el bucle por todos los ids mandados
	for($j = 0; $j < $cont; $j ++) {
		if ($get) {
			$id_almacen = $_GET["hidden_id_almacen_$j"];
			$id_lugar = $_GET["txt_id_lugar_$j"];
			$id_depto = $_GET["txt_id_depto_$j"];
			$codigo = $_GET["txt_codigo_$j"];
			$nombre = $_GET["txt_nombre_$j"];
			$direccion = $_GET["txt_direccion_$j"];
			$estado = $_GET["txt_estado_$j"];
			$tipo_control = $_GET["txt_tipo_control_$j"];
			//demasia añadido 17-11-2014
			$demasia = $_GET["txt_demasia_$j"];
		} else {
			$id_almacen = $_POST["hidden_id_almacen_$j"];
			$id_lugar = $_POST["txt_id_lugar_$j"];
			$id_depto = $_POST["txt_id_depto_$j"];
			$codigo = $_POST["txt_codigo_$j"];
			$nombre = $_POST["txt_nombre_$j"];
			$direccion = $_POST["txt_direccion_$j"];
			$estado = $_POST["txt_estado_$j"];
			$tipo_control = $_POST["txt_tipo_control_$j"];
			//demasia añadido 17-11-2014
			$demasia = $_POST["txt_demasia_$j"];
		}
		
		
		if ($id_almacen == "undefined" || $id_almacen == "" || $estado == 'undefined') {
			// //////////////////Inserción/////////////////////
			//en una insercion el almacen siempres debe ser registrado con estado='activo'
			if($estado == "" || $estado == null)$estado='activo';
			
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAlmacen("insert", $id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control);
			
			if (! $res) {
				// Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			
			// Validación satisfactoria, se ejecuta la inserción en la tabla tal_almacen
			$res = $Custom->InsertarAlmacen($id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia);
			if (! $res) {
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3]; 
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit(); 
			}
		} else { // /////////////////////Modificación////////////////////
		     
			//en una insercion el almacen siempres debe ser registrado con estado='activo'
			if($estado == "" || $estado == null || $estado == 'undefined')$estado='activo';
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAlmacen("update", $id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control);
			
			if (! $res) {
				// Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			  
			$res = $Custom->ModificarAlmacen($id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia);
			
			if (! $res) {
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit();
			}
		}
	} // END FOR
	  
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
		$mensaje_exito = "Se guardaron todos los datos.";
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = "id_almacen";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = "0=0";
	
	$res = $Custom->ContarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit();
} else {
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit();
}
?>
<?php ob_end_flush();?>