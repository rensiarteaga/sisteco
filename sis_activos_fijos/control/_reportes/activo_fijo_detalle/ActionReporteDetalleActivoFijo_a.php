<?php
/*
 * Nombre:	        ActionReporteDetalleActivoFijo.php
 * Proposito:		Genera un listado para el reporte detalle de activos fijos
 * Autor:			Daniel Sanchez Torrico 
 * Fecha:			09/04/2013
 */

session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFDetalleActivoFijo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$arreglo_cabeceras = array(
			"DISTINCT ACTIVO.codigo","ACTIVO.descripcion as nombre",
			"ACTIVO.descripcion_larga as descripcion","taf.descripcion as tipo_activo","saf.descripcion as subtipo_activo","ACTIVO.estado"," EF.descripcion as estado_funcional",
			"to_char(ACTIVO.fecha_compra, ''dd-mm-yyyy'') as fecha_compra","to_char(ACTIVO.fecha_ini_dep, ''dd-mm-yyyy'') as fecha_inicio_depreciacion",
			"ACTIVO.monto_compra","ACTIVO.num_factura","ACTIVO.monto_actual","ACTIVO.monto_actualiz","UBICACION.ubicacion as ubicacio","ACTIVO.vida_util_original","ACTIVO.vida_util_restante",
			"ACTIVO.flag_revaloriz","ACTIVO.proyecto","ACTIVO.observaciones","ACTIVO.origen","EMPLEA.nombre_completo as responsable",
			"(SELECT uo.nombre_unidad from kard.tkp_unidad_organizacional uo where uo.id_unidad_organizacional = (select kard.f_kp_obtener_gerencia_x_funcionario(emplea.id_empleado,NULL))) as unidad_organizacional",
			"frppa.nombre_financiador","frppa.nombre_regional","frppa.nombre_programa","frppa.nombre_proyecto","frppa.nombre_actividad","frppa.desc_epe","depto.nombre_depto");
	
	$cabecera = '';
	$posicion = array();
	
	if($txt_chk_kbeceras == 'true'){
	
		for($i = 0; $i<30;$i++){
			$valor = $_GET['txt_chk_cabecera_'.$i];
			if($valor=='true'){
				$cabecera = $cabecera." ".$arreglo_cabeceras[$i].",";
				$posicion[] = $i;
			}
		}
	}else{
		$posicion = array(0,1,2,5,6,7,8,9,13,20,21);
		foreach($posicion as $posi)
			$cabecera = $cabecera." ".$arreglo_cabeceras[$posi].",";
	}
	
	$cabecera = substr ($cabecera, 0, -1); //le quitamos la ultima coma.
	

	$id_financiador        		=  $txt_id_financiador;
	$id_regional           		=  $txt_id_regional;
	$id_programa           		=  $txt_id_programa;
	$id_proyecto           		=  $txt_id_proyecto;
	$id_actividad          		=  $txt_id_actividad;
			
	$id_tipo_activo				=  $txt_id_tipo_activo;
	$id_sub_tipo_activo			=  $txt_id_sub_tipo_activo;
	$id_unidad_organizacional	=  $txt_id_unidad_organizacional;	
	$id_estado_funcional		=  $txt_id_estado_funcional;	
	$estado             		=  $txt_estado;
	$proyecto					=  $txt_activo_proyecto;
	$activo_bien				=  $txt_activo_bien;
	
	$ubicacion_fisica			=  $txt_ubicacion_fisica;
	$nombre_descripcion			=  $txt_nombre_descripcion;
	
	$id_depto					=  $txt_departamento_activos;
	$departamento_activo        =  $txt_depto_af;
	$flag_ep					=  $txt_chk_ep;
	$flag_deprec                =  $txt_chk_fecha_deprec;
	$flag_compra				=  $txt_chk_fecha_compra;
	$tipo_reporte				=  $txt_criterio_reporte;
	
	
	$fecha_compra1      		=  $txt_fecha_compra1;
	$fecha_compra2      		=  $txt_fecha_compra2;	
	$fecha_deprec1      		=  $txt_fecha_deprec1;
	$fecha_deprec2      		=  $txt_fecha_deprec2;	
	
	$condicion					=  $txt_cmb_condicion;
	
	$tipo_activo 				=  $txt_tipo;
	$subtipo_activo 			=  $txt_subtipo;
	
	$criterio_filtro = '';	
	
	$criterio_filtro = $criterio_filtro." tipo.id_tipo_activo like ''".$id_tipo_activo."''";
	$criterio_filtro = $criterio_filtro." and sub.id_sub_tipo_activo like ''".$id_sub_tipo_activo."''";
	
	if($flag_ep=='true'){
		$criterio_filtro = $criterio_filtro." and frppa.id_financiador like ''".$id_financiador."''";
		$criterio_filtro = $criterio_filtro." and frppa.id_regional like ''".$id_regional."''";
		$criterio_filtro = $criterio_filtro." and frppa.id_programa like ''".$id_programa."''";
		$criterio_filtro = $criterio_filtro." and frppa.id_proyecto like ''".$id_proyecto."''";
		$criterio_filtro = $criterio_filtro." and frppa.id_actividad like ''".$id_actividad."''";
		
		
		$_SESSION['PDF_financiador'] = $txt_financiador;
		
		if($id_regional == '%')
			$_SESSION["PDF_regional"] = 'Todas las Regionales';
		else 
			$_SESSION['PDF_regional'] = $txt_regional;
		
		if($id_programa == '%')
			$_SESSION["PDF_programa"] = 'Todos los Programas';
		else 
			$_SESSION['PDF_programa'] = $txt_programa;
		
		if($id_proyecto == '%')
			$_SESSION["PDF_proyecto"] = 'Todos los Proyectos';
		else
			$_SESSION['PDF_proyecto'] = $txt_proyecto;
		
		if($id_actividad == '%')
			$_SESSION["PDF_actividad"] = 'Todas las Actividades';
		else
			$_SESSION['PDF_actividad'] = $txt_actividad;
		
		
		
		
		
	}
	
	if($id_unidad_organizacional!='' && $id_unidad_organizacional!='%'){
		$criterio_filtro = $criterio_filtro." and uniorg.id_unidad_organizacional like ''".$id_unidad_organizacional."''";
	}
	$criterio_filtro = $criterio_filtro." and ef.id_estado_funcional like ''".$id_estado_funcional."''";
	
	if($estado == 'no_eliminados')
		$criterio_filtro = $criterio_filtro." and activo.estado != ''eliminado''";
	else if($estado == 'no_elim_bajas')
		$criterio_filtro = $criterio_filtro." and activo.estado != ''eliminado'' and activo.estado != ''baja''";
	else
	  $criterio_filtro = $criterio_filtro." and activo.estado like ''".$estado."''";     
	
	$criterio_filtro = $criterio_filtro." and activo.proyecto like ''".$proyecto."''";
	$criterio_filtro = $criterio_filtro." and activo.tipo_af_bien like ''".$activo_bien."''";
	
	
	
	if($ubicacion_fisica!='' && $ubicacion_fisica!='%')
	{ 
			$criterio_filtro = $criterio_filtro." and ubicacion.id_ubicacion=".$ubicacion_fisica;
	}
	elseif ($ubicacion_fisica=='%'){$criterio_filtro = $criterio_filtro." and ubicacion.id_ubicacion like ''".$ubicacion_fisica."''";}
	
	
	
	$criterio_filtro = $criterio_filtro." and depto.id_depto like ''".$id_depto."''";
	
	
	if($flag_compra == 'true' and $flag_deprec == 'true'){
		$criterio_filtro = $criterio_filtro." and ((ACTIVO.fecha_compra >= ''$fecha_compra1'' and ACTIVO.fecha_compra <= ''$fecha_compra2'') ";
		$criterio_filtro = $criterio_filtro." ".$condicion." ";
		$criterio_filtro = $criterio_filtro." (ACTIVO.fecha_ini_dep >= ''$fecha_deprec1'' and ACTIVO.fecha_ini_dep <= ''$fecha_deprec2''))";
		
		$fc1 = explode("-",$fecha_compra1);
		$_SESSION["PDF_fecha_compra1"] = $fc1[1].'-'.$fc1[0].'-'.$fc1[2];
		
		$fc2 = explode("-",$fecha_compra2);
		$_SESSION["PDF_fecha_compra2"] = $fc2[1].'-'.$fc2[0].'-'.$fc2[2];
		
		$fd1 = explode("-",$fecha_deprec1);
		$_SESSION["PDF_fecha_deprec1"] = $fd1[1].'-'.$fd1[0].'-'.$fd1[2];
		
		$fd2 = explode("-",$fecha_deprec2);
		$_SESSION["PDF_fecha_deprec2"] = $fd2[1].'-'.$fd2[0].'-'.$fd2[2];
		
	}
	if($flag_compra == 'true' and $flag_deprec == 'false' ){
		$criterio_filtro = $criterio_filtro." and ACTIVO.fecha_compra >= ''$fecha_compra1'' and ACTIVO.fecha_compra <= ''$fecha_compra2''";
		$fc1 = explode("-",$fecha_compra1);
		$_SESSION["PDF_fecha_compra1"] = $fc1[1].'-'.$fc1[0].'-'.$fc1[2];
		
		$fc2 = explode("-",$fecha_compra2);
		$_SESSION["PDF_fecha_compra2"] = $fc2[1].'-'.$fc2[0].'-'.$fc2[2];
	}
	if($flag_compra == 'false' and $flag_deprec == 'true'){
		$criterio_filtro = $criterio_filtro." and ACTIVO.fecha_ini_dep >= ''$fecha_deprec1'' and ACTIVO.fecha_ini_dep <= ''$fecha_deprec2''";
		$fd1 = explode("-",$fecha_deprec1);
		$_SESSION["PDF_fecha_deprec1"] = $fd1[1].'-'.$fd1[0].'-'.$fd1[2];
		
		$fd2 = explode("-",$fecha_deprec2);
		$_SESSION["PDF_fecha_deprec2"] = $fd2[1].'-'.$fd2[0].'-'.$fd2[2];
	}
	
	$_SESSION['detalle_criterio_filtro'] = $criterio_filtro;
	$_SESSION['criterio_cabeceras'] = $cabecera;
	$_SESSION['posiciones_cabeceras'] = $posicion;

	if($tipo_reporte == '0')
	{
		header("location:../../../vista/_reportes/activo_fijo_detalle_analisis/XLSDetalleActivoFijo.php");
	}else{
		
		$_SESSION['nombre_descripcion'] = $nombre_descripcion;
		$_SESSION['PDF_tipo_activo'] = $tipo_activo;
		if($id_sub_tipo_activo == '%')
			$_SESSION["PDF_sub_tipo_activo"] = 'Todos los Subtipos de Activos';
		else
			$_SESSION['PDF_sub_tipo_activo'] = $subtipo_activo;	
		$_SESSION['PDF_ep'] = $flag_ep;	
		$_SESSION['PDF_fecha_compra'] = $flag_compra;	
		$_SESSION['PDF_fecha_deprec'] = $flag_deprec;	
		$_SESSION['PDF_estado_funcional'] = $txt_estado_funcional;
			
		if($estado == '%')
			$estado = 'Todos';
		if($proyecto == '%')
			$proyecto = 'Todos';
		if($activo_bien == '%')
			$activo_bien = 'Todos';
		
		$_SESSION["PDF_estado_af"] = $estado;
		$_SESSION["PDF_proyecto_af"] = $proyecto;
		$_SESSION["PDF_activo_bbr"] = $activo_bien;
		$_SESSION["PDF_unidad_af"] = $departamento_activo;
		
				
		$cant=0;
		$puntero=0;
		$sortcol='';
		$sortdir=''; 
		$res = $Custom->ReporteDetalleActivoFijoAnalisis($cant, $puntero, $sortdir, $sortcol, $criterio_filtro, $cabecera);
		
		$detalle = $Custom->salida;	
		//echo $Custom->query; exit;
		
		if($res){
			$_SESSION['PDF_Detalle_Activos'] = $detalle;			
			
			header("location:../../../vista/_reportes/activo_fijo_detalle_analisis/PDFDetalleActivoFijo.php");
		}
		
	}
	
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}
?>