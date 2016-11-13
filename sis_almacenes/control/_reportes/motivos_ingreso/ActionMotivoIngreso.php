<?php
/**
 * Nombre:	        ActionMotivoIngreso.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			
 * Fecha creación:	
 *
 */
session_start();
include_once('../../LibModeloAlmacenes.php');
include_once('../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBAlmacenes();

$nombre_archivo = 'ActionMotivoIngreso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$parametros = array ('$id_motivo_ingreso'=> $txt_id_motivo_ingreso);
	
	//Valid values are: Pdf, Ps, Html, etc
	if($txt_seleccion==1)
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/ral_motivo_ingreso.agt',$parametros);
	else 
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/ral_motivo_ingreso_cuenta.agt',$parametros);
	
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