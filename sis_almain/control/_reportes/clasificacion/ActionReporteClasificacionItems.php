<?php
/**
 * Nombre:	        ActionReporteClasificacionItems.php
 * Proposito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			
 * Fecha creacion:	
 *
 */
session_start();
include_once('../../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma(); 

$nombre_archivo = 'ActionClasificacionItem.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$cant=0;
	$puntero =0;
	$sortcol=NULL;
	$sortdir='ASC';
	$criterio_filtro='0=0';
	
	if($tipo == 'excel')
	{
		header("location:../../../vista/_reportes/clasificacion/XLS_ReporteClasificacionItems.php");
	}
	elseif($tipo == 'pdf')
	{
		$res = $Custom->ReporteClasificacionItems($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		if($res)
		{
			$_SESSION["PDF_clasificacion_it"] = $Custom->salida;
			header("location:../../../vista/_reportes/clasificacion/PDF_ReporteClasificacionItems.php");
		}
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