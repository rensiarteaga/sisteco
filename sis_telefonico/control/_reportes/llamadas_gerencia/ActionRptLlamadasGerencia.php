<?php
/**
 * Nombre:	        ActionRptDetalleMarcas.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloSistemaTelefonico.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = 'ActionRptLlamadasGerencia.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    $reporte = new cls_manejo_reportes();
	if($descripcion=="GGN" || $descripcion=="GTI"){
	$parametros = array ('$gerencia'=>$txt_gerencia,
    '$fecha_inicio'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin
	);
	}
	else{
	$parametros = array ('$gerencia'=>$id_gerencia,
    '$fecha_inicio'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin
	);
	}
	//Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rst_llamadas_gerencia.agt',$parametros);
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