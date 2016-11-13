<?php

session_start();
include_once("../../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionPDFEstadisticasEnviadas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'CUEDOC.fecha_sol, CUEDOC.nro_documento';	
	$sortdir = 'desc';
	
	
	$_SESSION['PDF_fecha_desde']=$_GET['fecha_inicio'];
	$_SESSION['PDF_fecha_hasta']=$_GET['fecha_fin'];
	$fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
	$fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
	 
	
	
	if($_GET['tipo_reporte']=='0'){
		$criterio_fil=" env.fecha_origen between ''$fecha_ini'' and  ''$fecha_fin''";
		$res = $Custom-> ListarEstadisticasEnviadasGlob(10000,0,'nombre_unidad asc,total_emitida desc','desc',$criterio_fil,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_estadisticas']=$Custom->salida;
		header("location:PDFEstadisticasEnviadasGlob.php");
		
	}
	else{
		$criterio_fil=" env.fecha_origen between ''$fecha_ini'' and  ''$fecha_fin''";
		$criterio_fil.=" and env.id_uo=".$_GET['id_unidad_organizacional'];
			
		$res = $Custom-> ListarEstadisticasEnviadasDet(10000,0,'empleado asc,total_emitida desc','desc',$criterio_fil,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_estadisticas']=$Custom->salida;
		header("location:PDFEstadisticasEnviadasDet.php");
	}
	
	
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>