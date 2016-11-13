<?php

/*
 * Nombre:	        ActionPDFDetalleDepreciacion.php
 * Propósito:		Genera un listado para el reporte a detalle de depreciaciones
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();

include_once("../../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFDetalleDepreciacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	
	$id_financiador = $txt_id_finaciador;
	$id_regional = $txt_id_regional;
	$id_programa = $txt_id_programa;
	$id_proyecto = $txt_id_proyecto;
	$id_actividad = $txt_id_actividad;
	$id_tipo_activo = $txt_id_tipo_activo;
	$id_sub_tipo_activo = $txt_id_sub_tipo_activo;
	
	$fecha_desde = $txt_fecha_desde;
	$fecha_hasta = $txt_fecha_hasta;	
	$financiador = $txt_financiador;
	$regional = $txt_regional;
	$programa = $txt_programa;
	$proyecto = $txt_proyecto;
	$actividad = $txt_actividad;
	$tipo = $txt_tipo;
	$subtipo = $txt_subtipo;
	$descripcion = $txt_descripcion;	
	$codigo = $txt_codigo;
	$descripcion_larga =$txt_descripcion_larga;
	$monto_compra =$txt_monto_compra;	
	$vida_util_original =$txt_vida_util_original;
	$fecha_ini_dep =$txt_fecha_ini_dep;	

	$fecha1=$fecha_ini_dep;
    $fecha2=date("d-m-Y",strtotime($fecha1));	
    $fecha_ini_dep = $fecha2;
	
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'DEPREC.fecha_hasta';	
	
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$criterio_filtro = $criterio_filtro." and DEPREC.fecha_hasta between ''$fecha_desde'' and ''$fecha_hasta''";	
	$criterio_filtro.=" and activo.id_activo_fijo like ''$txt_id_activo_fijo'' and sub.id_sub_tipo_activo like ''$txt_id_sub_tipo_activo'' and sub.id_tipo_activo like ''$txt_id_tipo_activo''";
	$criterio_filtro.=" and frppa.id_financiador like ''$txt_id_financiador'' and frppa.id_regional like ''$txt_id_regional'' and frppa.id_programa like ''$txt_id_programa'' and frppa.id_proyecto like ''$txt_id_proyecto'' and frppa.id_actividad like ''$txt_id_actividad''";
	
	$suma = $Custom-> SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION['PDF_sumas']=$Custom->salida;	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	$criterio_filtro = $criterio_filtro." and DEPREC.fecha_hasta between ''$fecha_desde'' and ''$fecha_hasta''";
	$criterio_filtro.=" and activo.id_activo_fijo like ''$txt_id_activo_fijo'' and sub.id_sub_tipo_activo like ''$txt_id_sub_tipo_activo'' and sub.id_tipo_activo like ''$txt_id_tipo_activo''";
	$criterio_filtro.=" and frppa.id_financiador like ''$txt_id_financiador'' and frppa.id_regional like ''$txt_id_regional'' and frppa.id_programa like ''$txt_id_programa'' and frppa.id_proyecto like ''$txt_id_proyecto'' and frppa.id_actividad like ''$txt_id_actividad''";
		
	//criterio_estado	
	$res = $Custom-> ReporteDetalleDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION["PDF_detalledep"]=$Custom->salida;

	$_SESSION['PDF_id_financiador'] = $id_finaciador;
	$_SESSION['PDF_id_regional'] = $id_regional;
	$_SESSION['PDF_id_programa'] = $id_programa;
	$_SESSION['PDF_id_proyecto'] = $id_proyecto;
	$_SESSION['PDF_id_actividad'] = $id_actividad;
	$_SESSION['PDF_id_tipo_activo'] = $id_tipo_activo;
	$_SESSION['PDF_id_sub_tipo_activo'] = $id_sub_tipo_activo;
	
	$_SESSION['PDF_fecha_desde']=$fecha_desde;
	$_SESSION['PDF_fecha_hasta']=$fecha_hasta;
	$_SESSION['PDF_financiador']=$financiador;
	$_SESSION['PDF_regional']=$regional;
	$_SESSION['PDF_programa']=$programa;
	$_SESSION['PDF_proyecto']=$proyecto;
	$_SESSION['PDF_actividad']=$actividad;
	$_SESSION['PDF_tipo']=$tipo;
	$_SESSION['PDF_subtipo']=$subtipo;
	$_SESSION['PDF_descripcion']=$descripcion;
	$_SESSION['PDF_codigo']=$codigo;
	$_SESSION['PDF_descripcion_larga']=$descripcion_larga;
	$_SESSION['PDF_monto_compra']=$monto_compra;
	$_SESSION['PDF_vida_util_original']=$vida_util_original;
	$_SESSION['PDF_fecha_ini_dep']=$fecha_ini_dep;
	
			
	if($res)$total_registros= $Custom->salida;			
		
	if($res)
	{
		header("Content-type: application/pdf; charset=iso-8859-15",true);
		header("location: ../../../vista/_reportes/detalle_depreciacion/PDFDetalleDepreciacion.php");		
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>