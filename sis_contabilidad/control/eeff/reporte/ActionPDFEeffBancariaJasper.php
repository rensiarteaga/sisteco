<?php
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionPDFEefDivisionJasper.php';

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
  		$ids_periodo=$_POST['ids_periodo'];
  		$ids_ctaban=$_POST['ids_ctaban'];
  		$sw_ctaban=$_POST['sw_ctaban'];
  		$eeff_moneda=$_POST['eeff_moneda'];
	} else {
  		$id_parametro=$_GET['id_parametro'];
  		$id_moneda=$_GET['id_moneda'];
  		$ids_periodo=$_GET['ids_periodo'];
  		$ids_ctaban=$_GET['ids_ctaban'];
  		$sw_ctaban=$_GET['sw_ctaban'];
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
		$reporte=new ReportDriver('repeeff_Bancaria_xls.jasper','sci',$tipo_reporte);
	}else{
		$reporte=new ReportDriver('repeeff_Bancaria.jasper','sci',$tipo_reporte);
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
	}
	$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
	$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
	$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
	$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
	$reporte->addParametro('id_parametro',$id_parametro,'Integer');
	$reporte->addParametro('ids_periodo',$ids_periodo);
	$reporte->addParametro('sw_ctaban',$sw_ctaban);
	$reporte->addParametro('ids_ctaban',$ids_ctaban);
	$reporte->addParametro('id_moneda',$id_moneda,'Integer');
	if($tipo_reporte=='pdf'){
		$reporte->addParametro('eeff_moneda',$eeff_moneda);
		$reporte->addParametro('eeff_usuario',$_SESSION['ss_nombre_usuario']);
	}
	$reporte->runReporte();
}
?>
