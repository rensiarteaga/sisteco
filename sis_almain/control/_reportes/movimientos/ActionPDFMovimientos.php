<?php
/**
 * Nombre:				ActionPDFMovimientos
 * Autor:				unknow
 * Fecha creaci�n:		08/07/2014
 *
 */
session_start();
include_once("../../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$Custom2 = new cls_CustomDBAlma();

$nombre_archivo = 'ActionPDFMovimientos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 100;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'detmov.id_detalle_movimiento';
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
	if($CantFiltros=="") $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$cond->add_criterio_extra("MOV.id_movimiento",$m_id_movimiento);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if ($id_solicitud_salida != null && $id_solicitud_salida!='' && $id_solicitud_salida != 'undefined')
	{
		$res = $Custom-> ListarMovimientoReporteSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	}
	else
	{	 
		$res = $Custom-> ListarMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

		if($res)
		{
			$criterio_filtro = " m.id_movimiento = $m_id_movimiento ";
			
			//llamada a la funcion para el pie del reporte
			$aux = $Custom2->ListarDatosEncargadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($aux)
				$_SESSION["PDF_datos_almacenero"]=$Custom2->salida;
				
		}
	}
		
	$_SESSION["PDF_movimiento"]=$Custom->salida;
	
	//llamada a la funcion para armar el pie del reporte
	$footReport = $Custom ->ListarPieMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_pie_movimiento"] = $Custom->salida;
	
	if($res)
	{
		header("location:../../../vista/_reportes/movimientos/PDFMovimientos.php?id_solicitud=$id_solicitud_salida&movimiento=$movimiento");
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
?>