<?php

session_start();
include_once("../LibModeloPresupuesto.php");
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 13/08/2009
 * Descripción: Reporte Ejecución por Partidas.
 * **/


$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFEjecucionPartida.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = '';
	else $sortcol = $sort;

	if($dir == "") $sortdir  = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

		$criterio_filtro = $cond->obtener_criterio_filtro();
			
		$_SESSION['PDF_id_parametro_r']=utf8_decode($_GET['id_parametro']);
		$id_moneda_r=$_GET['id_moneda'];
		$_SESSION['PDF_desc_moneda_r']=utf8_decode($_GET['desc_moneda']);
		$_SESSION['PDF_fecha_fin_pdf_r']=$_GET['fecha_fin_pdf'];
		$fecha_fin_r=utf8_decode($_GET['fecha_fin']);
		$id_partida_r=$_GET['id_partida'];
		$tipo_pres1=$_GET['tipo_pres'];
		$_SESSION['PDF_desc_partida_r']=utf8_decode($_GET['desc_partida']);
		$_SESSION['PDF_desc_pres_r']=$_GET['desc_pres'];
		$_SESSION['PDF_gestion_r']=$_GET['gestion_pres'];
		
		$criterio_filtro= $criterio_filtro." and parpre.id_partida=$id_partida_r  and partde.id_moneda=$id_moneda_r";
		
	$SETDetalle = $Custom->ListarEjecucionPorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_fin_r,$tipo_pres1,$id_moneda_r);
	
	
	$_SESSION['PDF_RPPDetalle']=$Custom->salida;
	

	 header("location: ../../vista/ejecucion_reporte/PDFDetalleEjecucionPartida.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>



