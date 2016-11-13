<?php
/**
 * Nombre:	        ActionReportePedidos.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			
 * Fecha creación:	
 *
 */
session_start();
include_once('../../LibModeloAlmacenes.php');
include_once('../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBAlmacenes();

$nombre_archivo = 'ActionReportePedidos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$parametros = array ('$id_actividad'=> $txt_id_actividad,
	'$id_almacen'=> $txt_id_almacen,
	'$id_almacen_logico'=>$txt_id_almacen_logico,
	'$id_financiador'=>$txt_id_financiador,
	'$id_programa'=>$txt_id_programa,
	'$id_proyecto'=>$txt_id_proyecto,
	'$id_regional'=>$txt_id_regional,
	'$fecha_cierre'=>$txt_fecha_cierre,
	'$fecha_apertura'=>$txt_fecha_apertura
	);
	//Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/ral_ingresos_logico.agt',$parametros);
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