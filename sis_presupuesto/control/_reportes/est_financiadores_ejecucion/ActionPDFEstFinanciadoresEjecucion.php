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
  			$id_unidad_organizacional= $_POST['id_unidad_organizacional'];
  			$id_financiador=$_POST['id_financiador'];
  			$reporte=$_POST['reporte'];
  			
		} else {
  			$id_moneda=$_GET['id_moneda'];
  			$id_parametro=$_GET['id_parametro'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$tipo_impresion=$_GET['tipo_impresion'];
  			$nombre_moneda=$_GET['desc_moneda'];
  			$id_unidad_organizacional= $_GET['id_unidad_organizacional'];
  			$monto_min= $_GET['monto_min'];
  			$monto_max= $_GET['monto_max'];
  			$id_financiador=$_GET['id_financiador'];
  			$reporte=$_GET['reporte'];
  			
  			}
		
      
		//Clase necesaria para la generación de reporte  
		 /*echo "reporte".$reporte;
		 echo "tipo_reporte".$tipo_reporte;
		*//*
		 echo "tipo_reporte".$tipo_reporte;
		 echo "tipo_impresion".$tipo_impresion;
		 echo "tipo_grafico".$tipo_grafico;
		 echo "nombre_moneda".$nombre_moneda;
		 echo "id_unidad_organizacional".$id_unidad_organizacional;*/
		// exit;
		/*echo $id_proyecto;
		exit;*/
		if ($reporte=='1' && $tipo_reporte=='0'){
			
			$reporte=0;
			$id_unidad_organizacional='%';
		}
		
		if ($reporte=='2' && $tipo_reporte=='0'){
			
			$reporte=0;
			$id_unidad_organizacional='%';
		}
		
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		switch ($reporte){
			//por unidades organizacionales
			case '0':
				  switch ($tipo_reporte){
				  	case '0': //resumen Global
				  	     	switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_gral_financiadores.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1':
    			               		$reporte=new ReportDriver('res_gral_financiadores.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_gral_financiadores.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				  		break;
				  	case '1'://Resumen Global a detalle
				  			switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1'://word
    			               		$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				  		break;
				  	default:
				  		switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1'://word
    			               		$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_det_financiadores.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				  	
				  }
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','pres_financiadores_ofertado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','pres_financiadores_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','pres_financiadores_vigente_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','pres_financiadores_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','pres_financiadores_ejecutado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','pres_financiadores_ejecutado_torta.jasper');
				break;
			case '1': //Por financiadores
			
			     
			       switch ($tipo_reporte){
			       	 
				   	case '1'://Resumen Global a detalle
				  	 
				  			switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1':
    			               		$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				  		break;
				  	
				  
				  default:
				 		switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1'://word
    			               		$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_financiadores_x_uo.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				           
			       }
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','financiadores_ofertado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','financiadores_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','financiadores_vigente_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','financiadores_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','financiadores_ejecutado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','financiadores_ejecutado_torta.jasper');
			break;
			case '2': //Por Proyectos
			
			     
			       switch ($tipo_reporte){
			       	 
				   	case '1'://Resumen Global a detalle
				  	 
				  			switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1':
    			               		$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				  		break;
				  	
				  
				  default:
				 		switch ($tipo_impresion) {
    			          		case '0'://pdf*/
    				              	$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','pdf');
       		             		break;
    			          		case '1'://word
    			               		$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','rtf');
       			
       			  		  		break;
    					  		case '2'://excel
     						   		$reporte=new ReportDriver('res_financiadores_x_proyecto.jasper','PRESTO','xls');
       			
      					  		break;
				           }
				           
			       }
				$reporte->addParametroURL('SUBREPORT_TAB_FOR','proy_financiadores_ofertado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_FOR','proy_financiadores_ofertado_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_VIG','proy_financiadores_vigente_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_VIG','proy_financiadores_vigente_torta.jasper');
				
				$reporte->addParametroURL('SUBREPORT_TAB_EJE','proy_financiadores_ejecutado_det_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TOR_EJE','proy_financiadores_ejecutado_torta.jasper');
			break;
		  }
	
		$fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $nombre_usuario=$_SESSION["ss_nombre_usuario"];
	
	  
		$codigo_hash=sha1($_SESSION['ss_id_usuario'].$_SESSION['ss_nombre_usuario'].$id_parametro.$id_unidad_organizacional.$tipo_pres.$id_moneda.gregoriantojd(date('m'),date('d'),date('Y')).$hora);
	
	    $reporte->addParametro('codigo_hash',$codigo_hash);
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
		$reporte->addParametro('id_financiador',$id_financiador);
		$reporte->addParametro('id_proyecto',$id_proyecto);
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('moneda',$nombre_moneda);
		
		$reporte->runReporte();
	}
?>
