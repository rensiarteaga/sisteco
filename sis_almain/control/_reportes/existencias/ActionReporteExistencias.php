<?php

/*
 * Nombre:	        ActionPDFTipoMovimientos.php
 * Prop�sito:		Genera un listado para el reporte de tipo de movimientos
 * Autor:			UNKNOW
 *
 */

session_start();

include_once("../../LibModeloAlma.php");
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionPDFExistencias.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	
		
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'alm.id_almacen';
	
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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

	$criterio_filtro = array("$h_id_almacen","$h_id_item","NULL","$txt_fecha_hasta");
	$puntero = $h_id_almacen;
	$sortcol = $txt_fecha_hasta;
	
	//echo $Custom->query;exit;
		
	if($txt_formato_reporte == 'pdf')
	{
		$res = $Custom->ReporteExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$_SESSION["pdf_existencias_almacen"] = $Custom->salida;
		header("location: ../../../vista/_reportes/existencias/PDFReporteExistenciasAlmacen.php?nombre_almacen=".$txt_nombre_almacen."&f_fin=".$txt_fecha_hasta);
	}
	else
	{
		$parametros = serialize (array('id_almacen'=>$puntero,'criterio'=>$criterio_filtro));
			
		header("location: ../../../vista/_reportes/existencias/XLSReporteExistenciasAlmacen.php?nombre_almacen=".$txt_nombre_almacen."&f_fin=".$txt_fecha_hasta."&param=".$parametros);
	}		
	
	
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>