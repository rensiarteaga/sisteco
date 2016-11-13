<?php

session_start();
include_once("../../LibModeloPresupuesto.php");
include_once('../../../../sis_parametros/control/LibModeloParametros.php');

/**
 * Autor: Grover Velasquez Colque
 * Fecha de mod: 13/07/2011
 * Descripción: Reporte Ejecución Fisica Financiera
 * **/

$Custom = new cls_CustomDBPresupuesto();
//$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionPDFEjecucionFisicaFinanciera.php';

//echo $_GET['tipo_reporte']; exit;

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 2000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nombre_proyecto';
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
		$_SESSION['PDF_id_moneda']=utf8_decode($_GET['id_moneda']);
		$_SESSION['PDF_desc_moneda_r']=utf8_decode($_GET['desc_moneda']);
		
		//$_SESSION['PDF_fecha_fin_pdf_r']=$_GET['fecha_fin_pdf'];
		//$_SESSION['PDF_fecha_ini_pdf_r']=$_GET['fecha_ini_pdf'];
		//$fecha_fin=utf8_decode($_GET['fecha_fin']);		
		//$fecha_ini=utf8_decode($_GET['fecha_ini']);		
		//$id_partida=$_GET['id_partida'];
		
		$_SESSION['PDF_tipo_pres']=$tipo_pres1=$_GET['tipo_pres'];
		//$_SESSION['PDF_desc_partida_r']=utf8_decode($_GET['desc_partida']);
		$_SESSION['PDF_desc_pres_r']=$_GET['desc_pres'];
		$_SESSION['PDF_gestion_r']=$_GET['gestion_pres'];
		$_SESSION['PDF_trimestre']=$_GET['trimestre'];
		
		$_SESSION['PDF_filtro']=$_GET['filtro'];
		$filtro=$_GET['filtro'];
		$_SESSION['PDF_id_presupuesto']=$id_presupuesto=$_GET['id_presupuesto'];
		$_SESSION['PDF_id_uo']=$id_uo=$_GET['id_uo'];		 
		$_SESSION['PDF_id_proyecto']=$id_proyecto=$_GET['id_proyecto'];
		
		/*$criterio_filtro="  id_proyecto in (SELECT distinct id_proyecto
                         			        FROM presto.vpr_presupuesto pres
                         			        WHERE pres.id_parametro=$id_parametro and pres.tipo_press in ($tipo_pres1))";
        $res = $Custom->ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	*/
		
		$criterio_filtro= " and pres.id_parametro = ".$_SESSION['PDF_id_parametro_r']. " and pardet.id_moneda = ".$_SESSION['PDF_id_moneda'];
        $res = $Custom->ListarEjecucionFisicaFinanciera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo);
		
		
		
	$_SESSION['PDF_Detalle_Proyectos']=$Custom->salida;	
	
	if ($_GET['formato_reporte'] == 1) 	//PDF
	{ 		
		header("location: ../../_reportes/ejecucion_fisica_financiera/PDFDetalleEjecucionFisicaFinanciera.php");
	}	
	else	// Excel
	{
		header("location: ../../_reportes/ejecucion_trimestral/XLSDetalleEjecucionAnual.php");	
	}
}
else
{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
}

?>