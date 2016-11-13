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
$nombre_archivo = 'ActionRptPrueba.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	//formatea fecha, obtenemos el último día del mes_fin  en la gestion_fin
	if($txt_periodico == "Si")
	{
		$time_ini=mktime(0,0,0,$txt_mes_ini +1,0,$txt_gestion_ini);
		$time_fin=mktime(0,0,0,$txt_mes_fin +1,0,$txt_gestion_fin);
		// Obtenemos la fecha
		$dia_mes_ini = date("d",$time_ini);
		$dia_mes_fin = date("d",$time_fin);
		//$txt_fecha_ini = "$txt_mes_ini-$dia_mes_ini-$txt_gestion_ini";
		//$txt_fecha_fin = "$txt_mes_fin-$dia_mes_fin-$txt_gestion_fin";

		$txt_fecha_ini = "$txt_gestion_ini-$txt_mes_ini-$dia_mes_ini";
		$txt_fecha_fin = "$txt_gestion_fin-$txt_mes_fin-$dia_mes_fin";

		
	}
	$reporte = new cls_manejo_reportes();
	//$parametros = null;
	$parametros = array ('$id_activo_fijo'=>$txt_id_activo_fijo,
	'$id_financiador'=>$txt_id_financiador,
	'$id_regional'=>$txt_id_regional,
	'$id_programa'=>$txt_id_programa,
	'$id_proyecto'=>$txt_id_proyecto,
	'$id_actividad'=>$txt_id_actividad,
	'$id_tipo_activo'=>$txt_id_tipo_activo,
	'$id_sub_tipo_activo'=>$txt_id_sub_tipo_activo,
	'$fecha_ini'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin
	);

	//Valid values are: Pdf, Ps, Html, etc
	//$reporte -> CreateReport('Pdf','../../../modelo/_reportes/prueba/primer_reporte.agt',$parametros);
	if($txt_periodico == "Si")
	{
		$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_depreciacion_periodico.agt',$parametros);
	}
	else
	{
		$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_depreciacion_total.agt',$parametros);
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