<?php

session_start();
include_once("../../LibModeloPresupuesto.php");
/**
 * Autor: Grover Velasquez Colque
 * Fecha de mod: 13/08/2009
 * Descripción: Reporte Ejecución por Partidas.
 * **/


$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFTraspasosReporte.php';

//echo $_GET['tipo_reporte']; exit;

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 1500;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'PRESUP2.desc_presupuesto, PARTRA.fecha_conclusion';
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
		$id_parametro=$_GET['id_parametro'];
		$id_moneda=$_GET['id_moneda'];
		$_SESSION['PDF_desc_moneda_r']=utf8_decode($_GET['desc_moneda']);
		
		$tipo_traspaso=$_GET['tipo_traspaso'];
		$_SESSION['PDF_desc_tipo_traspaso']=utf8_decode($_GET['desc_tipo_traspaso']);
		
		
		$_SESSION['PDF_fecha_ini']=utf8_decode($_GET['fecha_ini']);
		$_SESSION['PDF_fecha_fin']=utf8_decode($_GET['fecha_fin']);
		
		$fecha_ini = substr( $_SESSION['PDF_fecha_ini'],3,2)."/".substr($_SESSION['PDF_fecha_ini'],0,2)."/".substr( $_SESSION['PDF_fecha_ini'],6,4);
		$fecha_fin = substr( $_SESSION['PDF_fecha_fin'],3,2)."/".substr($_SESSION['PDF_fecha_fin'],0,2)."/".substr( $_SESSION['PDF_fecha_fin'],6,4);
				
		//$id_partida=$_GET['id_partida'];
		
		$tipo_pres1=$_GET['tipo_pres'];
		//$_SESSION['PDF_desc_partida_r']=utf8_decode($_GET['desc_partida']);
		$_SESSION['PDF_desc_pres_r']=$_GET['desc_pres'];
		$_SESSION['PDF_gestion_r']=$_GET['gestion_pres'];
		$_SESSION['PDF_trimestre']=$_GET['trimestre'];
		
		$_SESSION['PDF_filtro']=$_GET['filtro'];
		$filtro=$_GET['filtro'];
		$id_presupuesto=$_GET['id_presupuesto'];
		$id_uo=$_GET['id_uo'];
		$id_proyecto=$_GET['id_proyecto'];
		
		$id_presupuesto_destino=$_GET['id_presupuesto_destino'];
		$id_uo_destino=$_GET['id_uo_destino'];
		$id_proyecto_destino=$_GET['id_proyecto_destino'];
		
		
		
	
	switch ($_GET['tipo_reporte']) 
	{
		case 1:
			$criterio_filtro= $criterio_filtro." and pres.id_parametro = $id_parametro  and pardet.id_moneda = $id_moneda";
			$SETResumen = $Custom->ListarResumenTraspasosAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso);
			$_SESSION['PDF_Resumen']=$Custom->salida;		
		break;
		case 2:
			switch ($tipo_traspaso)
			{
				case '5':
					$tipo_traspaso='1';
					break;
				case '6':
					$tipo_traspaso='2';
					break;
				case '7':
					$tipo_traspaso='3';
					break;
				default:
					$tipo_traspaso='1,2,3';
					break;		
			}			
			
			$criterio_filtro= $criterio_filtro." and PARAMP.id_parametro = $id_parametro  and PARTRA.id_moneda = $id_moneda and PARTRA.tipo_traspaso in ($tipo_traspaso) ";
			$SETDetalle = $Custom->ListarDetalleTraspasosPorFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso,$id_presupuesto_destino,$id_uo_destino,$id_proyecto_destino);
			$_SESSION['PDF_Detalle']=$Custom->salida;
		break;		
	}
	
	
	
	
	if ($_GET['formato_reporte'] == 1) 	//PDF
	{ 	
		switch ($_GET['tipo_reporte']) 
		{
			case 1:
			header("location: ../../_reportes/traspasos_reporte/PDFResumenTraspasosAnual.php");		
			break;
			case 2:
			header("location: ../../_reportes/traspasos_reporte/PDFDetalleTraspasosPorFecha.php");
			break;		
		} 	
	}	
	else								// Excel
	{
		switch ($_GET['tipo_reporte']) 
		{
			case 1:
			header("location: ../../_reportes/traspasos_reporte/XLSResumenTraspasosAnual.php");		
			break;
			case 2:
			header("location: ../../_reportes/traspasos_reporte/XLSDetalleTraspasosPorFecha.php");
			break;			
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