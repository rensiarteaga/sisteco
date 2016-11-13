<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFEefConsolidaJasper.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_reporte_eeff=$_POST['id_reporte_eeff'];
	  		$id_parametro=$_POST['id_parametro'];
	  		$id_moneda=$_POST['id_moneda'];
	  		$id_deptos=$_POST['ids_depto'];
	  		$id_periodos=$_POST['ids_periodo'];
	  		$fecha_ini=$_POST['fecha_ini'];
	  		$fecha_fin=$_POST['fecha_fin'];
	  		$eeff_actual=$_POST['eeff_actual'];
	  		$eeff_nivel=$_POST['eeff_nivel'];
	  		$tipo_reporte=$_POST['tipo_reporte'];
	  		$eeff_nombre=$_POST['eeff_nombre'];
	  		$eeff_moneda=$_POST['eeff_moneda'];
	  		$sw_vista=$_POST['vista'];
		} else {
			$id_reporte_eeff=$_GET['id_reporte_eeff'];
	  		$id_parametro=$_GET['id_parametro'];
	  		$id_moneda=$_GET['id_moneda'];
	  		$id_deptos=$_GET['ids_depto'];
	  		$id_periodos=$_GET['ids_periodo'];
	  		$fecha_ini=$_GET['fecha_ini'];
	  		$fecha_fin=$_GET['fecha_fin'];
	  		$eeff_actual=$_GET['eeff_actual'];
	  		$eeff_nivel=$_GET['eeff_nivel'];
	  		$tipo_reporte=$_GET['tipo_reporte'];
	  		$eeff_nombre=$_GET['eeff_nombre'];
	  		$eeff_moneda=$_GET['eeff_moneda'];
	  		$sw_vista=$_GET['vista'];
	  	}
	  	
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		if($tipo_reporte=='xls'){
			if($sw_vista=='consolida'){$reporte=new ReportDriver('repeeff_Consolida_xls.jasper','sci',$tipo_reporte);}
			if($sw_vista=='periodo'){$reporte=new ReportDriver('repeeff_Periodo_xls.jasper','sci',$tipo_reporte);}
			if($sw_vista=='sumasal'){$reporte=new ReportDriver('repeeff_Sumas_xls.jasper','sci',$tipo_reporte);}
		}else{
			if($sw_vista=='consolida'){$reporte=new ReportDriver('repeeff_Consolida.jasper','sci',$tipo_reporte);}
			if($sw_vista=='periodo'){$reporte=new ReportDriver('repeeff_Periodo.jasper','sci',$tipo_reporte);}
			if($sw_vista=='sumasal'){$reporte=new ReportDriver('repeeff_Sumas.jasper','sci',$tipo_reporte);}
			
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('id_reporte_eeff',$id_reporte_eeff,'Integer');
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('id_deptos',$id_deptos);
		
		if($sw_vista=='periodo'){
			$reporte->addParametro('id_periodos',$id_periodos);
		}else{
			$reporte->addParametro('fecha_ini',$fecha_ini);
			$reporte->addParametro('fecha_fin',$fecha_fin);
		}
		
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
