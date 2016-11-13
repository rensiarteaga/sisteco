<?php
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionPDFDetalleCbteJasper.php';

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
  		$id_deptos=$_POST['id_deptos'];
  		$fecha_ini=$_POST['fecha_ini'];
  		$fecha_fin=$_POST['fecha_fin'];
  		$id_cuentas=$_POST['id_cuentas'];
  		$tipo_reporte=$_POST['tipo_reporte'];
	} else {
  		$id_parametro=$_GET['id_parametro'];
  		$id_moneda=$_GET['id_moneda'];
  		$id_deptos=$_GET['id_deptos'];
  		$fecha_ini=$_GET['fecha_ini'];
  		$fecha_fin=$_GET['fecha_fin'];
  		$id_cuentas=$_GET['id_cuentas'];
  		$tipo_reporte=$_GET['tipo_reporte'];
  	}
	
	//Clase necesaria para la generación de reporte 
	require_once('../../../../lib/lib_modelo/ReportDriver.php');
	
	//Aqui obtendre los datos de la cabecera
	$cant=10000000;
	$puntero=0;
	
	$sortdir='asc';
	$criterio_filtro=" 1=1";
	
	$reporte=new ReportDriver('repcbte_DetCbte.jasper','sci',$tipo_reporte);
	
	/*echo ('id_parametro'.$id_parametro);
	echo ('id_moneda'.$id_moneda);
	echo ('id_deptos'.$id_deptos);
	echo ('fecha_ini'.$fecha_ini);
	echo ('fecha_fin'.$fecha_fin);
	echo ('nombre_usuario'.$_SESSION['ss_nombre_usuario']);
	exit;*/
    
	$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
	$reporte->addParametro('id_parametro',$id_parametro,'Integer');
	$reporte->addParametro('id_moneda',$id_moneda,'Integer');
	$reporte->addParametro('id_deptos',$id_deptos);
	$reporte->addParametro('fecha_ini',$fecha_ini);
	$reporte->addParametro('fecha_fin',$fecha_fin);
	$reporte->addParametro('id_cuentas',$id_cuentas);
	$reporte->runReporte();
}
?>
