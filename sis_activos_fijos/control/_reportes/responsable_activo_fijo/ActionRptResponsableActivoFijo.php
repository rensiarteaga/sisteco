<?php
/**
 * Nombre:	        ActionRptResponsableActivoFijo.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloActivoFijo.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionRptResponsableActivoFijo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
		
	$parametros = array ('$id_empleado' =>  $hidden_id_empleado,
						'$id_financiador'=> $txt_id_financiador,
						'$id_regional'=> $txt_id_regional,
						'$id_programa'=> $txt_id_programa,
						'$id_proyecto'=> $txt_id_proyecto,
						'$id_actividad'=> $txt_id_actividad,
						);
	
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_responsable_activo_fijo.agt',$parametros);
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