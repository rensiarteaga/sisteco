<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionEliminarCaiff.php
 * Propósito:				Permite eliminar registros de la tabla tpr_caiff
 * Tabla:					tpr_caiff
 * Parámetros:				$hidden_id_caiff	--> id  

 * Valores de Retorno: Número de registros
 * Fecha de Creación:		
 * Versión:				
 * Autor:					
 * *********************************************************
 */
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionEliminarCaiff.php";

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = "NO";
}
if ($_SESSION['autentificado'] == "SI") {
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
	for($j = 0; $j < $cont; $j ++) {
		
		if ($get) {
			$id_caiff = $_GET["h_id_caiff_$j"];
		} else {
			$id_caiff = $_POST["h_id_caiff_$j"];
		}
		if ($id_caiff == "undefined" || $id_caiff == "") {
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el registro  especificado para eliminar.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit();
		} else 
		{
			$res = $Custom->EliminarCaiff($id_caiff);
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
		$sortcol = 'id_caiff';
	if ($sortdir == "")
		$sortdir = 'asc';
	if ($criterio_filtro == "")
		$criterio_filtro = '0=0';
	
	$res = $Custom->ContarCaiff($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
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