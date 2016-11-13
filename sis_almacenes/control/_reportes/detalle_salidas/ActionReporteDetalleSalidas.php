<?php
/**
 * Nombre:	        ActionReporteDetalleSalidas.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			
 * Fecha creación:	
 *
 */
session_start();
include_once('../../LibModeloAlmacenes.php');
include_once('../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBAlmacenes();

$nombre_archivo = 'ActionReporteDetalleSalidas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$parametros = array ('$id_almacen'=> $txt_id_almacen,
	'$id_almacen_ep'=>$txt_id_almacen_ep,
	'$id_almacen_logico'=>$txt_id_almacen_logico,
	'$estado_salida'=>$txt_estado,
	'$fecha_desde'=>$txt_fecha_desde,
	'$fecha_hasta'=>$txt_fecha_hasta
	);
	//Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/ral_detalle_salidas.agt',$parametros);
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