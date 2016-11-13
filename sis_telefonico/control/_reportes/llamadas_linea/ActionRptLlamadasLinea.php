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
$nombre_archivo = 'ActionRptLlamadasLinea.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
	$gestion=$txt_gestion;
	$mes=$txt_mes;
	$fecha_inicio=$mes."/01/".$gestion;
	if($txt_mes==1 || $txt_mes==3 || $txt_mes==5 || $txt_mes==7 || $txt_mes==8 || $txt_mes==10 || $txt_mes==12)
	{
		$fecha_fin=$mes."/31/".$gestion;
	}
	elseif ($txt_mes==4 || $txt_mes==6 || $txt_mes==9 || $txt_mes==11)
	{
		$fecha_fin=$mes."/30/".$gestion;
	}
	elseif($txt_mes==2)
	{
		$mod=$gestion%4;
		if($mod==0){$fecha_fin=$mes."/29/".$gestion;}
		else{$fecha_fin=$mes."/28/".$gestion;}
	}
	$parametros=array ('$linea'=>$txt_linea,
    '$fecha_inicio'=>$fecha_inicio,
    '$periodo'=>$mes,
	'$fecha_fin'=>$fecha_fin
	);
	$Custom->ListarNombreLlamada(1,0,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_linea);
	$txt_nombre_tipo_llamada = $Custom->salida;
	if($txt_nombre_tipo_llamada=="Local"){
		$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rst_llamadas_linea_local.agt',$parametros);
	}
    else{
     //Valid values are: Pdf, Ps, Html, etc
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/rst_llamadas_linea.agt',$parametros);	
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