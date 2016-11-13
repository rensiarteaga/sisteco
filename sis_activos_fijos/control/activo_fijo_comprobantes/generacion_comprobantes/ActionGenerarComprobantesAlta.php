<?php
/**
 **********************************************************
 Nombre de archivo:	    ActionGenerarComprobantesAlta.php
 Propósito:			    archivo donde se inicia el proceso de generacion de comprobantes de alta,una vez asociados las cuentas de un proceso de alta
 Tabla:				    actif.taf_activo_fijo_comprobante
 Parámetros:			$cantidad_ids
 						$id_grupo_proceso
 Valores de Retorno:    Mensaje de exito o error en caso de que los comprobantes hayan sido generados de forma correcta
 Fecha de Creación:		01/02/2013
 Versión:				1.1
 Autor:					Elmer Velasquez
 **********************************************************
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionGenerarComporbantesAlta.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//llamada a la funcion que permite generar los comprobantes de alta
	$res = $Custom->RegistrarComprobantesAlta($id_grupo_proceso);
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
		$resp->add_nodo("TotalCount", "nuevos comprobantes de  ALTA ");
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