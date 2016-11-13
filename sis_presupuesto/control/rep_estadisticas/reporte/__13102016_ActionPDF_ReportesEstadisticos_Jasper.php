<?php
	session_start();
	include_once('../../LibModeloPresupuesto.php');
	$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDF_ReportesEstadisticos.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_parametro = $_POST['id_parametro'];
	  		$fecha_ini = $_POST['fecha_ini'];
	  		$fecha_fin = $_POST['fecha_fin'];
	  		//$id_tipo_pres = $_POST['id_tipo_pres'];
	  		$id_moneda = $_POST['id_moneda'];
	  		$desc_moneda = $_POST['desc_moneda'];
	  		$desc_gestion = $_POST['desc_gestion'];
	  		
			$tipo_reporte = $_POST['tipo_reporte'];
		
		} else {
			$id_parametro = $_GET['id_parametro'];
	  		$fecha_ini = $_GET['fecha_ini'];
	  		$fecha_fin = $_GET['fecha_fin'];
	  		//$id_tipo_pres = $_GET['id_tipo_pres'];
	  		$id_moneda = $_GET['id_moneda'];
	  		$desc_moneda = $_GET['desc_moneda'];
	  		$desc_gestion = $_GET['desc_gestion'];
	  	
			$tipo_reporte = $_GET['tipo_reporte'];
		
	  	}
	  
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		if($tipo_reporte=='xls'){
				if($sw_ejecuta=='1'){$reporte=new ReportDriver('repejec_ConsAFech_xls.jasper','sci',$tipo_reporte);}
			
		}else{
			//$sw_det = $tipo_reporte;
			$tipo_reporte = 'pdf';
				if($sw_ejecuta=='1' ){$reporte=new ReportDriver('reporte1.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='2' ){$reporte=new ReportDriver('reporte2.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='3' ){$reporte=new ReportDriver('reporte3.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='4' ){$reporte=new ReportDriver('reporte4.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='5' ){$reporte=new ReportDriver('reporte5.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='6' ){$reporte=new ReportDriver('reporte6.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='7' ){$reporte=new ReportDriver('reporte7.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='8' ){$reporte=new ReportDriver('reporte8.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='9' ){$reporte=new ReportDriver('reporte91.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='10' ){$reporte=new ReportDriver('reporte101.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='11' ){$reporte=new ReportDriver('reporte11.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='12' ){$reporte=new ReportDriver('reporte12.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='13' ){$reporte=new ReportDriver('principal.jasper','sci',$tipo_reporte);}
				
				
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			$reporte->addParametro('imagen_1','../../../../lib/images/vmhe.png');
			$reporte->addParametro('imagen_2','../../../../lib/images/azulvmhe.png');
			$reporte->addParametro('SUBREPORT_DIR','../../../../sis_presupuesto/control/rep_estadisticas/reporte/');
		}
		//$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		//$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		/*$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('sw_admi',$sw_admi);*/
		
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		//$reporte->addParametro('id_tipo_pres',$id_tipo_pres);
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
     	$reporte->addParametro('fecha_ini',$fecha_ini);
     	$reporte->addParametro('fecha_fin',$fecha_fin);
		//$reporte->addParametro('sw_nivel',$sw_nivel);
		
		
		
		$reporte->addParametro('desc_moneda',$desc_moneda);
		$reporte->addParametro('desc_gestion',$desc_gestion);
		//$reporte->addParametro('desc_tipo_pres',$desc_tipo_pres);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$fuente='ENDESIS';
		$reporte->addParametro('fuente',$fuente);
		
		/*if($tipo_reporte=='pdf'){
			$reporte->addParametro('sw_det',$sw_det);
		}*/
		$reporte->runReporte();
	}
?>
