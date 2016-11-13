<?php
/**
 * Nombre:				ActionReporteDepreciacionXLS2.php
 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
 * 						de los activos fijos de la Gestion Actual
 * Autor:				Elmer Velasquez
 * Fecha creación:		21/04/2014
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteDepreciacionXLS2.php';

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
	
	$fecha_desde = 	"01/01/".$txt_ano_fin;
	$fecha_hasta =  $txt_mes_fin."/01/".$txt_ano_fin;
		
	header("location:../../../vista/_reportes/activo_fijo_depreciacion/XLS_ReporteActivoFijoDepreciacion2.php?id_grupo_dep=".$m_id_grupo_depreciacion."&fecha_desde=".$fecha_desde."&fecha_hasta=".$fecha_hasta);

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>