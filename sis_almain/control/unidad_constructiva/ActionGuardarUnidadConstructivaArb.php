<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarUnidadConstructivaArb.php
Proposito:				Permite insertar y modificar datos de las unidades constructivas
Tabla:					alma.tal_unidad_constructiva
Fecha de Creacion:		11-08-2014
Version:				1.0.0
Autor:					UNKNOW
**********************************************************
*/
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarUnidadConstructivaArb.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	
	$datosDecodificado = stripslashes($_REQUEST['datos']);
	$proceso = stripslashes($_REQUEST['proc']);
	
	$nodo = json_decode($datosDecodificado, true);
	if ($proc === 'add') { 
		$res = $Custom->InsertarUnidadConstructivaArb($nodo["hidden_id_unidad_constructiva_fk"], $nodo["txt_codigo"], $nodo["txt_nombre"],$nodo["txt_descripcion"],$nodo["txt_observaciones"],$nodo["txt_estado"],$nodo["txt_orden_uc"],$nodo["txt_cod_tramo"]);
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
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} elseif ($proc === 'upd') 
	{
		
		$res = $Custom->ModificarUnidadConstructivaArb($nodo["hidden_id_unidad_constructiva"], $nodo["hidden_id_unidad_constructiva_fk"], $nodo["txt_codigo"], $nodo["txt_nombre"],$nodo["txt_descripcion"],$nodo["txt_observaciones"],$nodo["txt_estado"],$nodo["txt_orden_uc"],$nodo["txt_cod_tramo"]);
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
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} 
	elseif ($proc === 'del') {
		$idUnidadConstArray = explode("-", $nodo['id']);
		$id_unidad_constructiva = $idUnidadConstArray[1];
		$res = $Custom->EliminarUnidadConstructivaArb($id_unidad_constructiva);
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
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} else {
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Proceso no identificado";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit();
	}
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