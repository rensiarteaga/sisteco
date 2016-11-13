<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionRechazarSolicitudClick.php
 * Propósito:				Permite rechazar solicitud de registros de la tabla tal_solicitud_salida
 * Tabla:					tal_solicitud_salida
 * Parámetros:				$id_solicitud_salida	--> id de solicitud_salida
 * $txt_id_usuario_asignacion
 *
 * Valores de Retorno: Número de registros
 * Fecha de Creación:		02-10-2013
 * Versión:				1.0.0
 * Autor:					Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();

include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionRechazarSolicitudClick.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = "NO";
}

if ($_SESSION['autentificado'] == "SI") {
	$get = true;
	if (sizeof($_GET) > 0) {
		$get = true;
	} elseif (sizeof($_POST) > 0) {
		$get = false;
	} else {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para cambiar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	}
	
	if ($get) {
		$id_solicitud_salida = $_GET["id_solicitud_salida"];
	} else {
		$id_solicitud_salida = $_POST["id_solicitud_salida"];
	}
	
	if ($id_solicitud_salida == "undefined" || $id_solicitud_salida == "") {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existe la solicitud salida especificado para cambiar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	} else {
		$res = $Custom->RechazarSolicitud($id_solicitud_salida);
		if (! $res) {
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
	
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
		$mensaje_exito = 'Se cambiaron los registros especificados.';
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = 'id_solicitud_salida';
	if ($sortdir == "")
		$sortdir = 'asc';
	if ($criterio_filtro == "")
		$criterio_filtro = '0=0';
	
	$res = $Custom->ContarRechazarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
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