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
$nombre_archivo = 'ActionRptCodigoBarras.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$reporte = new cls_manejo_reportes();
		
	$id_tipo_activo = $txt_id_tipo_activo;
	$id_sub_tipo_activo =  $txt_id_sub_tipo_activo;
	$id_activo_fijo = $txt_id_activo_fijo;
	$id_regional =  $txt_id_regional;
	/*$tamano = $txt_tamano;
	if ($tamano=='Grande')
	{
	header("location:PDFCodigoBarrasG.php?id_tipo_activo=$id_tipo_activo&id_sub_tipo_activo=$id_sub_tipo_activo&id_regional=$id_regional");	
	}
	elseif($tamano=='Mediano'){
	header("location:PDFCodigoBarrasM.php?id_tipo_activo=$id_tipo_activo&id_sub_tipo_activo=$id_sub_tipo_activo&id_regional=$id_regional");		
	}
	else{
		header("location:PDFCodigoBarrasP.php?id_tipo_activo=$id_tipo_activo&id_sub_tipo_activo=$id_sub_tipo_activo&id_regional=$id_regional");	
	}*/
	//$reporte = new cls_manejo_reportes();
	//$parametros = null;
	echo $txt_id_sub_tipo_activo;
	exit();
	$tamano = $txt_tamano;
	$parametros = array (
	                    '$id_financiador'=> $txt_id_financiador,
						'$id_regional'=> $txt_id_regional,
						'$id_programa'=> $txt_id_programa,
						'$id_proyecto'=> $txt_id_proyecto,
						'$id_tipo_activo'=> $txt_id_tipo_activo,
						'$id_sub_tipo_activo'=> $txt_id_sub_tipo_activo,
						'$id_activo_fijo'=> $txt_id_activo_fijo);
	                    
	//Valid values are: Pdf, Ps, Html, etc
	if ($tamano=='Mediano'){
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_codigo_barras_m.agt',$parametros);
	}
	elseif($tamano=='Pequeño'){
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_codigo_barras_p.agt',$parametros);	
	}
	else{
	$reporte -> CreateReport('Pdf','../../../modelo/_reportes/raf_codigo_barras_m.agt',$parametros);		
	}
	
}
else
{   $resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>