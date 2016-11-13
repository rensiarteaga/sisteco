<?php
/**
 * Nombre:				ActionReporteActivoFijoResponsable.php
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		       18/10/2012
 * Fecha ultima modificacion   02/05/2013
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
	
	if($txt_criterio_reporte == 0){
		
		$criterio_filtro = " afe.id_empleado =  $hidden_id_empleado_res ";
		$criterio_filtro_2 = " afemp.id_empleado =  $hidden_id_empleado_res ";
		
		$codigo_procedimiento = 'AF_RES_AF_SEL';
		
		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol, $codigo_procedimiento, $criterio_filtro,$criterio_filtro_2);
		
		if($res){
			
			$_SESSION['PDF_Detalle_Activos_Por_Responsable'] = $Custom->salida;
			
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_SoloActivos_Responsable.php");
			
			
		}			
		
		
	}elseif($txt_criterio_reporte == 1){
		

			$criterio_filtro = " afe.id_empleado = $hidden_id_empleado ";
			$criterio_filtro_2 = " afemp.id_empleado = $hidden_id_empleado ";
		
		
		$codigo_procedimiento = 'AF_ACT_RES_CUST_SEL';
		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol,$codigo_procedimiento,$criterio_filtro,$criterio_filtro_2);

		
		if($res){
			
			$_SESSION['PDF_Detalle_Activos_Por_Responsable'] = $Custom->salida;
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_Responsable.php");
		}
		
		
	}elseif($txt_criterio_reporte == 2){
		
	
		    $criterio_filtro = " afe.id_persona = $hidden_id_persona";
		    $criterio_filtro_2 = " per.id_persona = $hidden_id_persona";
		
		
		$codigo_procedimiento = 'AF_ACT_CUST_SEL';
		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol, $codigo_procedimiento,$criterio_filtro,$criterio_filtro_2);
		
		if($res){
				
			$_SESSION['PDF_Detalle_Activos_Por_Custodio'] = $Custom->salida;
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_Custodio.php");
		}
		
	}elseif($txt_criterio_reporte == 3){
		
		    header("location:../../../vista/_reportes/activo_fijo_responsable/XLS_ReporteActivoFijo_General.php");
	}

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>