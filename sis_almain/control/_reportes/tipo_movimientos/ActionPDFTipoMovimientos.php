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
$nombre_archivo = 'ActionPDFTipoMovimientos.php';

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
	//echo $h_tipo_movimiento;exit;
	for($i=0;$i<$CantFiltros;$i++) 
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$tipo_mov=utf8_decode($h_tipo_movimiento);
	
	if($tipo_mov=='solicitud')
	{	
		$criterio_filtro.=" AND mov.id_solicitud_salida IN (SELECT a.id_solicitud_salida 
                                            				FROM alma.tai_solicitud_salida a
                                            				WHERE a.estado=TRIM(''entregado'') AND a.id_empleado like(''$h_id_empleado'')
                                            				AND a.id_almacen LIKE($h_id_almacen) AND a.fecha_solicitud BETWEEN ''$txt_fecha_desde 00:00:00'' AND ''$txt_fecha_hasta 23:59:59'')";
		$res = $Custom->ReporteTipoMovimientosSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		
		if($res)
		{
			$_SESSION["pdf_tipo_movimientos_solicitud"] = $Custom->salida;
			header("location: ../../../vista/_reportes/tipo_movimiento/PDFReporteSolicitud.php?f_ini=".$txt_fecha_desde."&f_fin=".$txt_fecha_hasta."&id_empleado=".$h_id_empleado);
		}
	}	
	else//if ($tipo_mov=='ingreso' || $tipo_mov=="devolucion" || $tipo_mov=="transpaso_ingreso")
	{
		$criterio_filtro .= " AND det.id_movimiento IN( 	SELECT a.id_movimiento 
														FROM alma.tai_movimiento a 
													    WHERE a.id_almacen like($h_id_almacen) AND
													    a.id_tipo_movimiento like($h_id_tipo_movimiento) AND a.estado like(''finalizado'')
													    AND a.fecha_movimiento BETWEEN  ''$txt_fecha_desde 00:00:00 '' AND 	''$txt_fecha_hasta 23:59:59''											    
													)"; 
	
 		$res = $Custom->ReporteTipoMovimientos($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
	
		if($res) 
		{		
			$_SESSION["pdf_tipo_movimientos"] = $Custom->salida;
			header("location: ../../../vista/_reportes/tipo_movimiento/PDFReporteTipoMovimientos.php?f_ini=".$txt_fecha_desde."&f_fin=".$txt_fecha_hasta);		
		}
	}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>