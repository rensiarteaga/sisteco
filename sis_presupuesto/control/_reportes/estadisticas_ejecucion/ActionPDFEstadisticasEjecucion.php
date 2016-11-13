<?php
	session_start();
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  			$id_moneda=$_POST['id_moneda'];
  			$id_parametro=$_POST['id_parametro'];
  			$nombre_moneda=$_POST['desc_moneda'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			$tipo_impresion=$_POST['tipo_impresion'];
  			$tipo_grafico=$_POST['tipo_grafico'];
  			$id_unidad_organizacional= $_POST['id_unidad_organizacional'];
  			$monto_min= $_POST['monto_min'];
  			$monto_max= $_POST['monto_max'];
  			
		} else {
  			$id_moneda=$_GET['id_moneda'];
  			$id_parametro=$_GET['id_parametro'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$tipo_impresion=$_GET['tipo_impresion'];
  			$nombre_moneda=$_GET['desc_moneda'];
  			$tipo_grafico=$_GET['tipo_grafico'];
  			$id_unidad_organizacional= $_GET['id_unidad_organizacional'];
  			$monto_min= $_GET['monto_min'];
  			$monto_max= $_GET['monto_max'];
  			
  			}
		
      
		//Clase necesaria para la generación de reporte  
		/* echo "id_moneda".$id_moneda;
		
		 echo "id_parametro".$id_parametro;
		
		 echo "tipo_reporte".$tipo_reporte;
		 echo "tipo_impresion".$tipo_impresion;
		 echo "tipo_grafico".$tipo_grafico;
		 echo "nombre_moneda".$nombre_moneda;
		 echo "id_unidad_organizacional".$id_unidad_organizacional;
		 exit;*/
		
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		 if ($tipo_reporte=='0')
		 {  
		 
		 	 switch ($tipo_impresion) {
    			case '0'://pdf*/
    			
       			$reporte=new ReportDriver('res_gral_ejecucion.jasper','PRESTO','pdf');
       		     break;
    			case '1'://word
    			 /*echo 'entra aqui ddddd ';
		 	  exit;*/
       			$reporte=new ReportDriver('res_gral_ejecucion.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			$reporte=new ReportDriver('res_gral_ejecucion.jasper','PRESTO','xls');
       			
      			break;
				}
				
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','presupuesto_ofertado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','presupuesto_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','presupuesto_vigente_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','presupuesto_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','presupuestoejecutado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','presupuesto_ejecutado_torta.jasper');
	
		 	
		 	 
				
	}else if ($tipo_reporte=='1'){
		
		switch ($tipo_impresion) {
				
    			case '0'://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			
       			$reporte=new ReportDriver('res_det_ejecucion_x_pres.jasper','PRESTO','pdf');
       			 break;
    			case '1'://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('res_det_ejecucion_x_pres.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('res_det_ejecucion_x_pres.jasper','PRESTO','xls');
       			
      			break;
				}	
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','presupuesto_ofertado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','presupuesto_ofertado_det_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','presupuesto_vigente_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','presupuesto_vigente_det_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','presupuesto_ejecutado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','presupuesto_ejecutado_det_torta.jasper');
	 
	}else{
		switch ($tipo_impresion) {
		         case '0'://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			
       			$reporte=new ReportDriver('res_det_ejecucion.jasper','PRESTO','pdf');
       			 break;
    			case '1'://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('res_det_ejecucion.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('res_det_ejecucion.jasper','PRESTO','xls');
       			
      			break;
				}
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','presupuesto_ofertado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','presupuesto_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','presupuesto_vigente_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','presupuesto_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','presupuestoejecutado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','presupuesto_ejecutado_torta.jasper');
		
	}
	
	
	/*if($tipo_grafico=='0'){
		
		$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_pres.jasper');
			
	}else{
		
			$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_barras_x_pres.jasper');
	}		
	*/			//$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_pres.jasper');
				/*$reporte->addParametroURL('SUBREPORT_TAB_FOR','presupuesto_ofertado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','presupuesto_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','presupuesto_vigente_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','presupuesto_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','presupuestoejecutado_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','presupuesto_ejecutado_torta.jasper');*/
		$fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $nombre_usuario=$_SESSION["ss_nombre_usuario"];
	
	  
		$codigo_hash=sha1($_SESSION['ss_id_usuario'].$_SESSION['ss_nombre_usuario'].$id_parametro.$id_unidad_organizacional.$tipo_pres.$id_moneda.gregoriantojd(date('m'),date('d'),date('Y')).$hora);
	//	}
	 /*echo $codigo_hash;
	 exit;*/
	    $reporte->addParametro('codigo_hash',$codigo_hash);
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
		
		//$reporte->addParametro('tipo_pres',$tipo_pres,'Integer');
		
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('moneda',$nombre_moneda);
		
		$reporte->runReporte();
	}
?>
