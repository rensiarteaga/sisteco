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
			$reporte = $_POST['reporte'];
	  		$id_gestion = $_POST['id_gestion'];
	  		$sw_nivel = $_POST['sw_nivel'];
	  		$tipo_reporte = $_POST['tipo_reporte'];
	  		$desc_gestion = $_POST['desc_gestion'];
	  		$id_periodo = $_POST['id_periodo'];
	  		$fecha_inicio = $_POST['fecha_inicio'];
	  		$fecha_fin = $_POST['fecha_fin'];
	  		
		
		} else {
			$reporte = $_GET['reporte'];
			$id_gestion = $_GET['id_gestion'];
	  		$sw_nivel = $_GET['sw_nivel'];
	  		$tipo_reporte = $_GET['tipo_reporte'];
	  		$desc_gestion = $_GET['desc_gestion'];
	  		$id_periodo = $_GET['id_periodo'];
	  		 
	  		$fecha_inicio = $_GET['fecha_inicio'];
	  		$fecha_fin = $_GET['fecha_fin'];
	  		 
	  		
			}
	 
		//Clase necesaria para la generación de reporte
		$desc_gestion_anterior=$desc_gestion-1; 

		require_once('../../../lib/lib_modelo/ReportDriver.php');
		   if($reporte=='anual'){
			  $reporte=new ReportDriver('caif.jasper','presto',$tipo_reporte);
		   }else{
		   	   $reporte=new ReportDriver('caif_mensual.jasper','presto',$tipo_reporte);
		   	
		   }
				
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			$reporte->addParametro('SUBREPORT_DIR','../../../../sis_presupuesto/control/caiff/');
		
		$reporte->addParametro('pm_id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		/*$reporte->addParametro('pm_ip',$_SESSION['ss_ip']);
		$reporte->addParametro('pm_mac',$_SESSION['ss_mac']);
		
		$reporte->addParametro('pr_id_caiff',$id_caiff,'Integer');*/
            /*  echo $_SESSION['ss_id_usuario'].'--';
              echo $id_gestion.'--';
              echo $sw_nivel.'--';
              echo $id_periodo.'--';
              echo $fecha_inicio.'--';
              echo $fecha_fin.'--';
              exit;*/
     	$reporte->addParametro('pr_id_gestion',$id_gestion,'Integer');
     	$reporte->addParametro('pr_gestion',$desc_gestion);
     //	$reporte->addParametro('pr_gestion_ant',$desc_gestion_anterior);
     	$reporte->addParametro('pr_niveles',$sw_nivel,'Integer');
       $reporte->addParametro('pr_id_periodo',$id_periodo,'Integer');
		   	   $reporte->addParametro('pr_fecha_ini',$fecha_inicio);
		   	   $reporte->addParametro('pr_fecha_fin',$fecha_fin);
		
		//$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$fuente='ENDESIS';
		
		$reporte->runReporte();
	}
?>
