 <?php
/**
 * Nombre:				
 * Autor:				
 * Fecha creación:		
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionReporteDepreciacionPDF.php';

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
	
	if( $m_id_grupo_depreciacion != null)
	{
		$criterio_filtro = array("$m_id_grupo_depreciacion","$fecha_hasta");
		$res =$Custom->ReporteActivosFijosDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		//echo $Custom->query; exit;
		
		if($res)
		{
			$_SESSION['PDF_reporte_depreciacion_nuevo2'] = $Custom->salida;
			//header("location:../../../vista/_reportes/activo_fijo_depreciacion/PFD_ReporteActivoFijoDepreciacion.php");//elmer
			header("location:../../../vista/_reportes/activo_fijo_depreciacion/PDF_ReporteActivoFijoDepreciacionAuditoriaInterna.php");//daniel
			
			/*$det_af = $_SESSION["PDF_reporte_depreciacion_nuevo2"];
			foreach($det_af[0] as $det)
				echo $det.'<br>';*/
			
			//header("location:../../../vista/_reportes/activo_fijo_depreciacion/PFD_ReporteActivoFijoDepreciacionDetalladoAudit.php");//daniel
		}
		else
		{
			echo  "error funcion";
		}
	}
	/*$res = $Custom->ReporteActivosFijosDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
	if($res)
	{
		$_SESSION['PDF_reporte_depreciacion_nuevo2'] = $Custom->salida;
		header("location:../../../vista/_reportes/activo_fijo_depreciacion/PFD_ReporteActivoFijoDepreciacion.php");
	}
	else
	echo "problemas con la funcion";*/
	/*if($txt_criterio_reporte == 0){
		
		if($hidden_id_activo_fijo != '%'){
			$_SESSION['PDF_Activos_Todos'] = null;
			$criterio_filtro = "afe.estado = ''activo'' AND af.id_activo_fijo = $hidden_id_activo_fijo";
		}
		else {
			$_SESSION['PDF_Activos_Todos'] = 'Todos'; 
			$criterio_filtro = "afe.estado = ''activo'' AND af.id_activo_fijo like ''%''";
		}

		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		if($res){
			
			$_SESSION['PDF_Detalle_Activos_Por_Activo'] = $Custom->salida;
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_Activo.php");
			
		}		
		
	}elseif($txt_criterio_reporte == 1){
		
		if($hidden_id_empleado != '%'){		
			$_SESSION['PDF_Responsables_Todos'] = null;
			$criterio_filtro = "afe.estado = ''activo'' AND afe.id_empleado = $hidden_id_empleado ORDER BY nombre_custodio DESC";
		}
		else{
			$_SESSION['PDF_Responsables_Todos'] = 'Todos';
		    $criterio_filtro = "afe.estado = ''activo'' AND afe.id_empleado like ''%'' ORDER BY nombre_responsable,nombre_custodio DESC";
		}
		
		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		if($res){
			
			$_SESSION['PDF_Detalle_Activos_Por_Responsable'] = $Custom->salida;
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_Responsable.php");
		}
		
		
	}elseif($txt_criterio_reporte == 2){
		
		if($hidden_id_persona != '%'){
			$_SESSION['PDF_Custodios_Todos'] = null;
			$criterio_filtro = "afe.estado = ''activo'' AND per.id_persona = $hidden_id_persona";
		}
		else{
			$_SESSION['PDF_Custodios_Todos'] = 'Todos';
		    $criterio_filtro = "afe.estado = ''activo'' AND afe.id_persona like ''%'' ORDER BY nombre_custodio ASC";
		}
		
		$res = $Custom->ReporteActivoFijoResponsableCustodio($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		if($res){
				
			$_SESSION['PDF_Detalle_Activos_Por_Custodio'] = $Custom->salida;
			header("location:../../../vista/_reportes/activo_fijo_responsable/PDF_ReporteActivoFijo_x_Custodio.php");
		}
		
	}elseif($txt_criterio_reporte == 3){
		
		    header("location:../../../vista/_reportes/activo_fijo_responsable/XLS_ReporteActivoFijo_General.php");
	}*/

}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}
?>