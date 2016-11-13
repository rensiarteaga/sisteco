<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionEliminarDepreciacionGestionDetalle.php
 * Propósito:				Permite eliminar registros de la tabla actif.tpm_depreciacion_gestion
 * Tabla:					tpm_depreciacion_gestion
 * Parámetros:				$h_id	--> id 
 * Valores de Retorno: 		Número de registros
 * Fecha de Creación:		29092015
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionEliminarDepreciacionGestionDetalle.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = "NO";
}

if ($_SESSION['autentificado'] == "SI") 
{
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
	} elseif (sizeof($_POST) > 0) {
		$get = false;
		$cont = $_POST['cantidad_ids'];
	} else {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Eliminar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	}
	echo 'llega';exit;
	for($j = 0; $j < $cont; $j ++) {
		
		if ($get) {
			$id_depreciacion_gestion_detalle = $_GET["id_depreciacion_gestion_det_$j"];
		} else {
			$id_depreciacion_gestion_detalle = $_POST["id_depreciacion_gestion_det_$j"];
		}
		
		if ($id_depreciacion_gestion_detalle == "undefined" || $id_depreciacion_gestion_detalle == "") {
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el almacen  especificada para eliminar.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit();
		} else { // Eliminación
			$res = $Custom->EliminarDepreciacionGestionDetalle($id_depreciacion_gestion_detalle);
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
	} // end for
	  
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
		$mensaje_exito = 'Se eliminaron los registros especificados.';
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol ='dg.id';
	if ($sortdir == "")
		$sortdir = 'asc';
	if ($criterio_filtro == "")
		$criterio_filtro = " dg.id_depreciacion_gestion = $id_depreciacion_gestion ";
	
	$res = $Custom-> ContarDepreciacionGestionDetalle($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
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