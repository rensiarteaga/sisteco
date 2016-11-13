<?php
	session_start();
	include_once('../../LibModeloPresupuesto.php');
	$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDF_Repeje_Detalle_Jasper.php';
	
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
			$id_tipo_pres = $_POST['id_tipo_pres'];
			$id_moneda = $_POST['id_moneda'];
			$desc_moneda = $_POST['desc_moneda'];
			$desc_gestion = $_POST['desc_gestion'];
			$desc_tipo_pres = $_POST['desc_tipo_pres'];
			
			$id_presupuesto = $_POST['id_presupuesto'];
			$desc_ppto = $_POST['desc_ppto'];
			$id_partida = $_POST['id_partida'];
			$desc_partida = $_POST['desc_partida'];
			
			$tipo_reporte = $_POST['tipo_reporte'];
			$sw_vista = $_POST['sw_vista'];
			$sw_ejecuta = $_POST['sw_ejecuta'];
		} else {
			$id_parametro = $_GET['id_parametro'];
			$fecha_ini = $_GET['fecha_ini'];
			$fecha_fin = $_GET['fecha_fin'];
			$id_tipo_pres = $_GET['id_tipo_pres'];
			$id_moneda = $_GET['id_moneda'];
			$desc_moneda = $_GET['desc_moneda'];
			$desc_gestion = $_GET['desc_gestion'];
			$desc_tipo_pres = $_GET['desc_tipo_pres'];
			
			$id_presupuesto = $_GET['id_presupuesto'];
			$desc_ppto = $_GET['desc_ppto'];
			$id_partida = $_GET['id_partida'];
			$desc_partida = $_GET['desc_partida'];
			
			$tipo_reporte = $_GET['tipo_reporte'];
			$sw_vista = $_GET['sw_vista'];
			$sw_ejecuta = $_GET['sw_ejecuta'];
	  	}
	  	
	  	$sw_admi = 'IN'; $sw_sql = 'PP';
	  	
		//Clase necesaria para la generación de reporte 
	  	require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		if($tipo_reporte=='xls'){
			if($sw_ejecuta=='1'){$reporte=new ReportDriver('repejec_DetPpto_xls.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='2'){$reporte=new ReportDriver('repejec_DetPpto_xls.jasper','sci',$tipo_reporte);}
		}else{
			$sw_det = $tipo_reporte;
			$tipo_reporte = 'pdf';
			if($id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_DetPpto.jasper','sci',$tipo_reporte);}
			if($id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_DetPpto_rec.jasper','sci',$tipo_reporte);}
		
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		}
		/*echo ('fecha_ini '.$sw_ejecuta);
		echo (' fecha_fin '.$tipo_reporte);
		exit();*/
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('sw_admi',$sw_admi);
		
		if($sw_ejecuta=='1'){$reporte->addParametro('id_codproc','PR_EJEDPTO_SEL');}
		if($sw_ejecuta=='2'){$reporte->addParametro('id_codproc','PR_EJEDPAR_SEL');}
		
		$reporte->addParametro('fecha_ini',$fecha_ini);
		$reporte->addParametro('fecha_fin',$fecha_fin);
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		$reporte->addParametro('id_tipo_pres',$id_tipo_pres);
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		
		$reporte->addParametro('id_presupuesto',$id_presupuesto,'Integer');
		$reporte->addParametro('desc_ppto',$desc_ppto);
		
		$reporte->addParametro('id_partida',$id_partida);
		$reporte->addParametro('desc_partida',$desc_partida);
		
		if($tipo_reporte=='pdf'){
			$reporte->addParametro('desc_moneda',$desc_moneda);
			$reporte->addParametro('desc_gestion',$desc_gestion);
			$reporte->addParametro('desc_tipo_pres',$desc_tipo_pres);
			$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
			$reporte->addParametro('sw_det',$sw_det);
		}
		$reporte->runReporte();
	}
?>
