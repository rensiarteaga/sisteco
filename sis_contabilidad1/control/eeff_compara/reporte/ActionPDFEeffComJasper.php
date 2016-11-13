<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFEeffComJasper.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_eeff=$_POST['id_eeff'];
			$sw_rep=$_POST['sw_rep'];
		} else {
			$id_eeff=$_GET['id_eeff'];
			$sw_rep=$_GET['sw_rep'];
  		}
		$tipo_reporte = 'pdf';
		
		/*echo ('id_eeff'.$id_eeff);
		echo ('sw_rep'.$sw_rep);
	    echo ('tipo_reporte'.$tipo_reporte);
	    exit();*/
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';

		if ($sw_rep == 1){
			$reporte=new ReportDriver('reportEEFFCompara.jasper','sci',$tipo_reporte);
		}
		if ($sw_rep == 2){
			$reporte=new ReportDriver('reportEEFFComparaNiv.jasper','sci',$tipo_reporte);
		}
		if ($sw_rep == 3){
			$reporte=new ReportDriver('reportEEFFComparaNota.jasper','sci',$tipo_reporte);
		}
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		$reporte->addParametro('id_eeff',$id_eeff,'Integer');
		$reporte->runReporte();
	}
?>
