<?php

/*
 * Nombre:	        ActionPDFDetalleDepreciacion.php
 * Propósito:		Genera un listado para el reporte a detalle de depreciaciones
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFDetalleDepreciacion.php';

//echo $txt_descripcion_larga;
//exit;

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	
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
	
	//echo $criterio_filtro;
	//exit;
	
	//criterio_estado	
	$res = $Custom-> ReporteDetalleDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION["PDF_detalledep"]=$Custom->salida;
	
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
	
	//$criterio_filtro = '0=0';
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$criterio_filtro = $criterio_filtro." and DEPREC.fecha_hasta between ''$fecha_desde'' and ''$fecha_hasta''";
	
	$suma = $Custom-> SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION['PDF_sumas']=$Custom->salida;	
			
	if($res)$total_registros= $Custom->salida;			
		
	if($res)
	{
		header("Content-type: application/pdf; charset=iso-8859-15",true);
		header("location: ../../../vista/_reportes/detalle_depreciacion/PDFDetalleDepreciacion.php");				
		
		
		//direccion: 
		
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
		echo "No tiene los permisos necesarios ";

}?>