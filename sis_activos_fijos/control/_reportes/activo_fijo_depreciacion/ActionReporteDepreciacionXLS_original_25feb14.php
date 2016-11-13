<?php
/**
 * Nombre:				ActionReporteDepreciacionNuevo.php
 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
 * 						de los activos fijos de la Gestion Actual
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		23/11/2012
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteActivoFijoResponsableCustodio.php';

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
		
	header("location:../../../vista/_reportes/activo_fijo_depreciacion/XLS_ReporteActivoFijoDepreciacion.php?id_grupo_dep=".$m_id_grupo_depreciacion."&fecha_hasta=".$fecha_hasta);
	//header("location:../../../vista/_reportes/activo_fijo_depreciacion/XLS_ReporteActivoFijoDepreciacion_x_tipo.php?id_grupo_dep=".$m_id_grupo_depreciacion."&fecha_hasta=".$fecha_hasta);

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>