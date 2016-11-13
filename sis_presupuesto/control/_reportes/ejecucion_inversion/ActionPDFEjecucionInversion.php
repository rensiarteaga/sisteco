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
  			$tipo_pres=$_POST['id_tipo_pres'];
  			$id_parametro=$_POST['id_parametro'];
  			$nombre_moneda=$_POST['desc_moneda'];
  			$tipo_impresion=$_POST['tipo_impresion'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			
  			
		} else {
  			$id_moneda=$_GET['id_moneda'];
  			$tipo_pres=$_GET['id_tipo_pres'];
  			$id_parametro=$_GET['id_parametro'];
  			$tipo_impresion=$_GET['tipo_impresion'];
  			$nombre_moneda=$_GET['desc_moneda'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  		}
		
      
		//Clase necesaria para la generación de reporte 
		
	/*	echo $tipo_pres;
			echo $id_moneda;
		echo $id_parametro;
		echo $tipo_impresion;
		echo $tipo_grafico;
		echo $nombre_moneda;
		exit;*/
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		/* if ($tipo_reporte=='0')
		 {  
		 	 
		 	 switch ($tipo_impresion) {
    			case '0'://pdf
    			
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','pdf');
       		     break;
    			case '1'://word
    			
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total_x_proyecto.jasper','PRESTO','xls');
       			0
      			break;
				}
		 	
		 	 
				
	}else{*/
		switch ($tipo_impresion) {
    			case '0'://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			 
       			$reporte=new ReportDriver('ejecucion_vs_inversion.jasper','PRESTO','pdf');
       			 break;
    			case '1'://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('ejecucion_vs_inversion.jasper','PRESTO','rtf');
       			
       			 break;
    			case '2'://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('ejecucion_vs_inversion.jasper','PRESTO','xls');
       			
      			break;
				}	 
	//
	
//	if($tipo_grafico=='0'){
		
			$reporte->addParametroURL('SUBREPORT_DIR','ejecucion_inversion_tabla.jasper');
			
	/*}else{
		
			$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_barras_x_proyecto.jasper');
			
	}
				//  $reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_proyecto.jasper');
				$reporte->addParametroURL('SUBREPORT_TABLA','presupuesto_ofer_ejecutado_tabla_x_proyecto.jasper');
			   
		
		*/
		
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		if ($tipo_reporte==0){
		$pm_sortcol='pres.nombre_proyecto,';
		$pm_sortdir='';
			
		}else{
		$pm_sortcol="(coalesce (pres.nombre_proyecto,'')||' - ' ||coalesce(pres.nombre_financiador,''))::varchar  ,";
		$pm_sortdir=',nombre_financiador';
			
		}
		$reporte->addParametro('tipo_pres',$tipo_pres,'Integer');
		$reporte->addParametro('tipo_press',$tipo_pres);
		
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('moneda','Bs');
		$reporte->addParametro('pm_sortcol',$pm_sortcol);
		$reporte->addParametro('pm_sortdir',$pm_sortdir);
		
		
		$reporte->runReporte();
	}
?>
