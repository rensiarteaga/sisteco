<?php
/**
 * Nombre:	        ActionClasificacionServicios.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			JoSé Mita
 * Fecha creación:	20-05-2008
 *
 */
session_start();
include_once('../../LibModeloAdquisiciones.php');
include_once('../../../../lib/lib_control/cls_manejo_reportes.php');
$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionClasificacionServicio.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$parametros = array ('$id_tipo_adq'=> $txt_id_tipo_adq);
	//Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rad_clasificacion_servicios.agt',$parametros);
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