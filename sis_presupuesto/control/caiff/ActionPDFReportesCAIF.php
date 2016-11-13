<?php
	session_start();
	include_once('../LibModeloPresupuesto.php');
	$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDFReportesCAIF.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_caiff = $_POST['id_caiff'];
	  		$id_gestion = $_POST['id_gestion'];
	  		$sw_ejecuta = $_POST['sw_ejecuta'];
		
		} else {
			$id_caiff = $_GET['id_caiff'];
	  		$id_gestion = $_GET['id_gestion'];
	  		$sw_ejecuta = $_GET['sw_ejecuta'];
		
	  	}
	 
		//Clase necesaria para la generación de reporte 
		require_once('../../../lib/lib_modelo/ReportDriver.php');
		
			//$sw_det = $tipo_reporte;
		
				if($sw_ejecuta=='balance' ){$reporte=new ReportDriver('rep_caiff_balance.jasper','presto','pdf');}
				if($sw_ejecuta=='diferencias' ){$reporte=new ReportDriver('rep_caiff_diferencias.jasper','presto','pdf');}
				if($sw_ejecuta=='cuenta_fasoc' ){$reporte=new ReportDriver('rep_caiff_cuentas_faltan_asociar.jasper','presto','pdf');}
				
				
				
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			//$reporte->addParametro('imagen_1','../../../../lib/images/vmhe.png');
			//$reporte->addParametro('imagen_2','../../../../lib/images/azulvmhe.png');
			$reporte->addParametro('SUBREPORT_DIR','../../../sis_presupuesto/control/caiff/');
		
		//$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('pm_id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('pm_ip',$_SESSION['ss_ip']);
		$reporte->addParametro('pm_mac',$_SESSION['ss_mac']);
		/*$reporte->addParametro('sw_admi',$sw_admi);*/
		
		
		//$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		//$reporte->addParametro('id_moneda',$id_moneda,'Integer');
     	$reporte->addParametro('pr_id_caiff',$id_caiff,'Integer');
     	$reporte->addParametro('pr_id_gestion',$id_gestion,'Integer');
		
		
		/*$reporte->addParametro('desc_moneda',$desc_moneda);
		$reporte->addParametro('desc_gestion',$desc_gestion);*/
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$fuente='ENDESIS';
		/*$reporte->addParametro('fuente',$fuente);
		*/
		/*if($tipo_reporte=='pdf'){
			$reporte->addParametro('sw_det',$sw_det);
		}*/
		$reporte->runReporte();
	}
?>
