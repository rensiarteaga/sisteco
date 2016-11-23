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
include_once('../../../reportes/RComposicionTUC.php');
$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionReporteFaltanteTUC.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$nombreArchivo = 'FaltantesUC.pdf';
	$cant=100000;
	$puntero=0;
	$sortcol='PEDINT.id_pedido_tuc_int';
	$sortdir='asc';
	$criterio_filtro=' PEDINT.id_salida = '.$hidden_id_salida;	
	$Custom=new cls_CustomDBAlmacenes();
	$Custom->ComposicionTUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
	$resp=$Custom->salida;
	/*
	print ("<pre>");
	print_r($resp);
	print ("</pre>");
	exit;
	*/
	
	$parametros = array (
	 						'tamano'=> 'LETTER',
	 						'orientacion'=> 'P',
	 						'titulo'=> 'Compisición Unidad Constructiva',
	 						'nombre_archivo'=> $nombreArchivo,
	 						'tipoReporte' => 'pdf',
	 						'codSistema'  => 'ALMIN'
						);	
    
	$reporte = new RComposicionTUC($parametros);
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