<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarTipoUnidadConstructiva.php
Propósito:				Permite eliminar registros de la tabla tal_tipo_unidad_constructiva
Tabla:					tal_tal_tipo_unidad_constructiva
Parámetros:				$hidden_id_tipo_unidad_constructiva


Valores de Retorno:    	Número de registros
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../arv_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionEliminarTipoUnidadConstructiva.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	
	
	
		$tmp['success'] = 'true';
		echo json_encode($tmp);
		exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>