<?php
/**
**********************************************************
Nombre de archivo:	    ActionRegistrarComprobantes.php
Propósito:				Permite registrar los comprobantes de
						diario en el conin

Fecha de Creación:		2012-12-13
Versión:				1.0.0
Autor:					Daniel Sanchez Torrico
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionGuardarDeposito.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	
	
	
	
	$cant = 0;
	$puntero = 0;  
	$sortdir = ''; 
	$sortcol = ''; 
	$criterio_filtro = '';
	$id_grupo_dep = $id_grupo_depreciacion;
	$fecha_fin = $fecha_hasta;
	$cod_regional = $codigo_regional;
	

	$res = $Custom->RegistrarActivosFijosDepreciacionComprobantes($cant, $puntero, $sortdir, $sortcol, $criterio_filtro,$id_grupo_dep,$fecha_fin,$cod_regional);
	
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", "nuevos comprobantes de ".$cod_regional." en los ");
	$resp->add_nodo("mensaje", "Este es el Mensaje");
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
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