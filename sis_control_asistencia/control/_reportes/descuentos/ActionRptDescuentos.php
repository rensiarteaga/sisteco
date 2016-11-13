<?php
/**
 * Nombre:	        ActionRptResponsableActivoFijo.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloControlAsistencia.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$CustomAsistencia = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionRptDescuentos.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_empleado';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$txt_fecha_fin=substr($txt_fecha_fin,3,2)."-".substr($txt_fecha_fin,0,2)."-".substr($txt_fecha_fin,6,4);
	$res = $CustomAsistencia->Descuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_id_empleado,$txt_fecha_ini,$txt_fecha_fin);
	
	$atraso = $CustomAsistencia->salida;
	$parametros = array ('$id_empleado'=>$txt_id_empleado,
	'$fecha_inicio'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin,
	'$atraso'=>$atraso
	);
	
	if($atraso <='00:30:59')
	{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_descuentos0.agt',$parametros);
	}
	elseif($atraso >= '00:31:00' AND $atraso <='00:45:59')
	{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_descuentos1.agt',$parametros);
	}
	elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59')
	{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_descuentos2.agt',$parametros);
	}
	elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00')
	{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_descuentos3.agt',$parametros);
	}
	else 
	{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rca_descuentos4.agt',$parametros);
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