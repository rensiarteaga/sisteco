<?php
session_start();
include_once('../../LibModeloPresupuesto.php');
$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFEjecComparaJasper.php';

//Se valida la autentificación
if (!isset($_SESSION['autentificado'])){
	echo "El usuario no se encuentra autentificado";
}

if($_SESSION['autentificado']=='SI')
{
	//Se valida el método de paso de variables del formulario
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  		$id_parametro=$_POST['id_parametro'];
  		$id_moneda=$_POST['id_moneda'];
  		$id_depto=$_POST['id_depto'];
  		$id_pptos=$_POST['id_pptos'];
  		$fecha_ini=$_POST['fecha_ini'];
  		$fecha_fin=$_POST['fecha_fin'];
  		$tipo_reporte=$_POST['tipo_reporte'];
  		$ejec_moneda=$_POST['ejec_moneda'];
  		$ejec_depto=$_POST['ejec_depto'];
  		
	} else {
  		$id_parametro=$_GET['id_parametro'];
  		$id_moneda=$_GET['id_moneda'];
  		$id_depto=$_GET['id_depto'];
  		$id_pptos=$_GET['id_pptos'];
  		$fecha_ini=$_GET['fecha_ini'];
  		$fecha_fin=$_GET['fecha_fin'];
  		$tipo_reporte=$_GET['tipo_reporte'];
  		$ejec_moneda=$_GET['ejec_moneda'];
  		$ejec_depto=$_GET['ejec_depto'];
  	}
	
	//Clase necesaria para la generación de reporte 
	require_once('../../../../lib/lib_modelo/ReportDriver.php');
	
	//Aqui obtendre los datos de la cabecera
	$cant=10000000;
	$puntero=0;
	
	$sortdir='asc';
	$criterio_filtro=" 1=1";
	
	if($tipo_reporte=='xls'){
		$reporte=new ReportDriver('reportEjecucion_Compara_xls.jasper','sci',$tipo_reporte);
	}else{
		$reporte=new ReportDriver('reportEjecucion_Compara.jasper','sci',$tipo_reporte);
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
	}
	$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
	$reporte->addParametro('id_parametro',$id_parametro,'Integer');
	$reporte->addParametro('id_moneda',$id_moneda,'Integer');
	$reporte->addParametro('id_depto',$id_depto,'Integer');
	$reporte->addParametro('id_pptos',$id_pptos);
	$reporte->addParametro('fecha_ini',$fecha_ini);
	$reporte->addParametro('fecha_fin',$fecha_fin);
	if($tipo_reporte=='pdf'){
		$reporte->addParametro('ejec_moneda',$ejec_moneda);
		$reporte->addParametro('ejec_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->addParametro('ejec_depto',$ejec_depto);
	}
	$reporte->runReporte();
}
?>
