<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFPlanCtaJasper.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_gestion=$_POST['id_gestion'];
			$sw_rep=$_POST['sw_rep'];
		} else {
			$id_gestion=$_GET['id_gestion'];
			$sw_rep=$_GET['sw_rep'];
  		}
		$tipo_reporte = 'pdf';
		
		$sel_gestion= " GESTION.id_gestion = ".$id_gestion;
		/*echo ('id_eeff'.$id_eeff);
		echo ('sw_rep'.$sw_rep);
	    echo ('tipo_reporte'.$tipo_reporte);
	    exit();*/
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';
		
		if ($sw_rep != 3) {$reporte=new ReportDriver('repconin_PlanCta.jasper','sci',$tipo_reporte);}
		if ($sw_rep == 3) {$reporte=new ReportDriver('repconin_PlanCtaSig.jasper','sci',$tipo_reporte);}
		
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		if ($sw_rep == 1) {$cod_proc = "CT_REPCTAS_SEL";}
		if ($sw_rep == 2) {$cod_proc = "CT_REPCTAUX_SEL";}
		if ($sw_rep == 3) {$cod_proc = "CT_REPCTASIG_SEL";}
		
		$reporte->addParametro('cod_proc',$cod_proc);
		$reporte->addParametro('sel_gestion',$sel_gestion);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->runReporte();
	}
?>
