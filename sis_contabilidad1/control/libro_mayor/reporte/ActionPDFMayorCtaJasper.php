<?php
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionPDFEefConsolidaJasper.php';

//Se valida la autentificación
if (!isset($_SESSION['autentificado'])){
	echo "El usuario no se encuentra autentificado";
}

if($_SESSION['autentificado']=='SI')
{
	//Se valida el método de paso de variables del formulario
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id_reporte_eeff=$_POST['id_reporte_eeff'];
  		$id_parametro=$_POST['id_parametro'];
  		$id_moneda=$_POST['id_moneda'];
  		$id_deptos=$_POST['id_deptos'];
  		$fecha_ini=$_POST['fecha_ini'];
  		$fecha_fin=$_POST['fecha_fin'];
  		$eeff_actual=$_POST['eeff_actual'];
  		$eeff_nivel=$_POST['eeff_nivel'];
  		$tipo_reporte=$_POST['tipo_reporte'];
  		$eeff_nombre=$_POST['eeff_nombre'];
  		$eeff_moneda=$_POST['eeff_moneda'];
  		
	} else {
		$id_reporte_eeff=$_GET['id_reporte_eeff'];
  		$id_parametro=$_GET['id_parametro'];
  		$id_moneda=$_GET['id_moneda'];
  		$id_deptos=$_GET['id_deptos'];
  		$fecha_ini=$_GET['fecha_ini'];
  		$fecha_fin=$_GET['fecha_fin'];
  		$eeff_actual=$_GET['eeff_actual'];
  		$eeff_nivel=$_GET['eeff_nivel'];
  		$tipo_reporte=$_GET['tipo_reporte'];
  		$eeff_nombre=$_GET['eeff_nombre'];
  		$eeff_moneda=$_GET['eeff_moneda'];
  	}
	
	//Clase necesaria para la generación de reporte 
	require_once('../../../../lib/lib_modelo/ReportDriver.php');
	
	//Aqui obtendre los datos de la cabecera
	$cant=10000000;
	$puntero=0;
	
	$sortdir='asc';
	$criterio_filtro=" 1=1";
	
	if($tipo_reporte=='xls'){
		$reporte=new ReportDriver('reportEEFFConsolidaXls.jasper','sci',$tipo_reporte);
	}else{
		$reporte=new ReportDriver('reportEEFFConsolida.jasper','sci',$tipo_reporte);
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
	}
	$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
	$reporte->addParametro('id_reporte_eeff',$id_reporte_eeff,'Integer');
	$reporte->addParametro('id_parametro',$id_parametro,'Integer');
	$reporte->addParametro('id_moneda',$id_moneda,'Integer');
	$reporte->addParametro('id_deptos',$id_deptos);
	$reporte->addParametro('fecha_ini',$fecha_ini);
	$reporte->addParametro('fecha_fin',$fecha_fin);
	$reporte->addParametro('eeff_actual',$eeff_actual);
	$reporte->addParametro('eeff_nivel',$eeff_nivel,'Integer');
	if($tipo_reporte=='pdf'){
		$reporte->addParametro('eeff_nombre',$eeff_nombre);
		$reporte->addParametro('eeff_moneda',$eeff_moneda);
		$reporte->addParametro('eeff_usuario',$_SESSION['ss_nombre_usuario']);
	}
	$reporte->runReporte();
}
?>
