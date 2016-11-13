<?php
/**
 * Nombre:				ActionReporteDepreciacionGestion.php
 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
 * 						de los activos fijos 
 * Autor:				UNKNOW
 * Fecha creaci�n:	23/10/2015
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteDepreciacionGestion.php';

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

	$num_dias=date("d",mktime(0,0,0,$mes_fin+1,0,$anio_fin));
		
	header("location:../../../vista/_reportes/depreciacion_gestion/XLS_ReporteDepreciacionGestionPHPExcel.php?id_grupo_dep=".$m_id_depreciacion_gestion."&fecha_hasta=".$fecha_hasta.'&fecha_desde='.$fecha_desde.'&mes_ini='.$mes_ini.'&anio_ini='.$anio_ini.'&mes_fin='.$mes_fin.'&anio_fin='.$anio_fin.'&num_dias='.$num_dias);

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>