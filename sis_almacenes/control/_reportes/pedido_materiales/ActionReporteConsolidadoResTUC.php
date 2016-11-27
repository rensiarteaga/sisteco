<?php
/**
 * Nombre:	        ActionReporteFaltanteTUC.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			
 * Fecha creación:	
 *
 */
session_start();
include_once('../../rac_LibModeloAlmacenes.php');
include_once('../../../../lib/lib_reportes/ReportePDF.php');
include_once('../../../reportes/RConsolidadoResTUC.php');
$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionReporteConsolidadoResTUC.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$nombreArchivo = 'ConsolidadoResUC.pdf';
	
	$Custom=new cls_CustomDBAlmacenes();
	$Custom->ConsolidadoTUC($hidden_id_salida);	
	$resp=$Custom->salida;
	/*
	print ("<pre>");
	print_r($resp);
	var_dump($resp);
	print ("</pre>");
	exit;*/
	
	
	$parametros = array (
	 						'tamano'=> 'LETTER',
	 						'orientacion'=> 'P',
	 						'titulo'=> 'Compisición Unidad Constructiva',
	 						'nombre_archivo'=> $nombreArchivo,
	 						'tipoReporte' => 'pdf',
	 						'codSistema'  => 'ALMIN'
						);	
    
	$reporte = new RConsolidadoResTUC($parametros);
	$reporte->datosHeader($resp);
	$reporte->generarReporte();
	$reporte->output();
	
	
	
	
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