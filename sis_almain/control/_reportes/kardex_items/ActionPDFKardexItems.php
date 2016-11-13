<?php

/*
 * Nombre:	        ActionPDFKardexItems.php
 * Prop�sito:		Genera un listado para el reporte del kardex de items
 * Autor:			UNKNOW
 *
 */

session_start();

include_once("../../LibModeloAlma.php");
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionPDFKardexItems.php';

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

	if($sort == '') $sortcol = 'mov.fecha_finalizacion';
	
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
	//echo $h_tipo_movimiento;exit;
	for($i=0;$i<$CantFiltros;$i++) 
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	//$desde = new DateTime($txt_fecha_desde);
	//$hasta = new DateTime($txt_fecha_hasta);
	
	$criterio_filtro = array("$h_id_almacen","$txt_id_item",date_format(date_create($txt_fecha_desde),'m/d/Y'),date_format(date_create($hasta),'m/d/Y'));
			
	$res = $Custom->ReporteKardexItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
	
	if($res)
	{
		$_SESSION["pdf_kardex_items"] = $Custom->salida;
		header("location: ../../../vista/_reportes/kardex_items/PDFKardexItems.php?f_ini=".$txt_fecha_desde."&f_fin=".$txt_fecha_hasta."&id_item=".$txt_id_item);
	}
	
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>