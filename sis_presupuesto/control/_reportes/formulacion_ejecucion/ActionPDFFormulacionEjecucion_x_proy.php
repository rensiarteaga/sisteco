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
  			$tipo_pres=$_POST['tipo_pres'];
  			$id_parametro=$_POST['id_parametro'];
  			$id_proyecto=$_POST['id_proyecto'];
  			$nombre_moneda=$_POST['desc_moneda'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			$tipo_impresion=$_POST['tipo_impresion'];
  			$tipo_grafico=$_POST['tipo_grafico'];
  			
  			
		} else {
  			$id_moneda=$_GET['id_moneda'];
  			$tipo_pres=$_GET['tipo_pres'];
  			$id_parametro=$_GET['id_parametro'];
  			$id_proyecto=$_GET['id_proyecto'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$tipo_impresion=$_GET['tipo_impresion'];
  			$nombre_moneda=$_GET['desc_moneda'];
  			$tipo_grafico=$_GET['tipo_grafico'];
  			}
		
      
		//Clase necesaria para la generación de reporte 
		/* echo "id_moneda".$id_moneda;
		 echo "tipo_pres".$tipo_pres;
		 echo "id_parametro".$id_parametro;
		 echo "id_proyecto".$id_proyecto;
		 echo "tipo_reporte".$tipo_reporte;
		 echo "tipo_impresion".$tipo_impresion;
		 echo "nombre_moneda".$nombre_moneda;
		 exit; */
		
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		 if ($tipo_reporte=='0')
		 {  
		 	 
		 	 switch ($tipo_impresion) {
    			case '0'://pdf*/
    			
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','pdf');
       		     break;
    			case '1'://word
    			 /*echo 'entra aqui ddddd ';
		 	  exit;*/
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','xls');
       			
      			break;
				}
		 	
		 	 
				
	}else{
		switch ($tipo_impresion) {
    			case '0'://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			 
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_x_proyecto.jasper','PRESTO','pdf');
       			 break;
    			case '1'://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_x_proyecto.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_x_proyecto.jasper','PRESTO','xls');
       			
      			break;
				}	 
	}
	
	if($tipo_grafico=='0'){
		
			$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_proyecto.jasper');
			
	}else{
		
			$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_barras_x_proyecto.jasper');
			
	}
				//  $reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_proyecto.jasper');
				$reporte->addParametroURL('SUBREPORT_TABLA','presupuesto_ofer_ejecutado_tabla_x_proyecto.jasper');
			   
		
		
		
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		
		$reporte->addParametro('id_proyecto',$id_proyecto);
		
		$reporte->addParametro('tipo_pres',$tipo_pres,'Integer');
		
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('moneda',$nombre_moneda);
		
		$reporte->runReporte();
	}
?>
