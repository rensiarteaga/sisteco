<?php
/**
**********************************************************
Nombre de archivo:	   	ActionGenerarComprobantesBaja.php
Propósito:			   	archivo donde se inicia el registro de los comprobantes de baja integracion ACTIF-CONIN
Fecha de Creación:		01/02/2013	
Tabla:					actif.taf_activo_fijo_comprobante
Parametros:				$cantidad_ids-> 1
						$id_grupo_proceso -> id del grupo proceso del cual se generarian los comprobantes de baja
Versión:				1.1
Autor:					Elmer Velasquez
**********************************************************
*/
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionGenerarComprobantesBaja.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	
	//$id_grupo_proceso=$id_grupo_proceso;
	
	$res = $Custom->RegistrarComprobantesBaja($id_grupo_proceso);
	if(!$res)
	{
		$resp = new cls_manejo_mensajes(true,"406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
		
	}
	else
	{
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("TotalCount", "nuevos comprobantes BAJA");
		$resp->add_nodo("mensaje", "Este es el Mensaje");
		$resp->add_nodo("tiempo_resp", "200");
		echo $resp->get_mensaje();
		exit;
	}
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