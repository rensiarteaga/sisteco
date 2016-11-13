<?php
	session_start();
	include_once('../../LibModeloTesoreria.php');
	$Custom = new cls_CustomDBTesoreria();
	$nombre_archivo = 'ActionPasajeVia_Jasper.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_cuenta_doc_det = $_POST['id_cuenta_doc_det'];
		} else {
			$id_cuenta_doc_det = $_GET['id_cuenta_doc_det'];
	  	}
	  	
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$tipo_reporte = 'pdf';
		$reporte=new ReportDriver('repdev_Pasaje_uti.jasper','sci',$tipo_reporte);
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('id_cuenta_doc_det',$id_cuenta_doc_det);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->runReporte();
	}
?>
