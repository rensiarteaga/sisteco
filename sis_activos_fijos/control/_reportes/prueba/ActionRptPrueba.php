<?php
/**
 * Nombre:	        Actioncls_manejo_arbol.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Rensi Arteaga
 * Fecha creación:	11-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloActivoFijo.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionRptPrueba.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	//$parametros = array ('$login_usuario' => 'rensi','$vari'=>'valor');
	$parametros = null;
	//Valid values are: Pdf, Ps, Html, etc
	//$reporte -> CreateReport('Pdf','../../../modelo/_reportes/prueba/primer_reporte.agt',$parametros);
	$reporte -> CreateReport('csv','../../../modelo/_reportes/prueba/veimar.agt',$parametros);
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



