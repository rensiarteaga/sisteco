<?php
/**
 * Nombre:				ActionReporteTipoActivoXLS.php
 * Descripcion:			Permite la recuperacion de la informacion referente a los tipos y subtipos de activos fijos
 * Autor:				UNKNOW
 * Fecha creaci�n:		21/07/2015
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteTipoActivoXLS.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
} 
if($_SESSION['autentificado']=='SI')
{
	$cant = 0;
	$puntero = 0;
	$sortdir = '';
	$sortcol = '';
	$criterio_filtro = "";	
		
		
	header("location:../../../vista/_reportes/tipo_activo/XLS_ReporteTipoActivo.php");

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>