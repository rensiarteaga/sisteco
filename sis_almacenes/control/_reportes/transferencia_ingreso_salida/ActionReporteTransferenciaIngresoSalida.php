<?php
/**
 * Nombre:	          ActionReporteTransferenciaIngresoSalida.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:		JoSé Abraham Mita Huanca	
 * Fecha creación:	18-03-2008
 *
 */

session_start();
include_once('../../LibModeloAlmacenes.php');
include_once('../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBAlmacenes();

$nombre_archivo = 'ActionReporteTransferenciaIngresoSalida.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	
	$parametros = array ('$id_persona'=> $hidden_id_persona);
	//Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/ral_transferencia_ingreso_salida.agt',$parametros);
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