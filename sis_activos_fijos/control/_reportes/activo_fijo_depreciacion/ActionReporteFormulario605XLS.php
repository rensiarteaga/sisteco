<?php
/**
 * Nombre:				ActionReporteFormulario605.php
 * Descripcion:			Recupera el detalle de los Af depreciados para el formulario 605
 * Autor:				Elmer Velasquez
 * Fecha creación:		26/03/2014
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteFormulario605.php';

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
		
	
	$fecha_hasta = 	$txt_mes_fin."/01/".$txt_ano_fin;
	header("location:../../../vista/_reportes/activo_fijo_depreciacion/XLS_ReporteFormulario605.php?id_grupo_dep=".$m_id_grupo_depreciacion);

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>