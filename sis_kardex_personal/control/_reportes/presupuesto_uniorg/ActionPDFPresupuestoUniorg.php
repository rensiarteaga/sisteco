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
  			$id_unidad_organizacional=$_POST['id_unidad_organizacional'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			
		} else {
  			$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  		}
		
  
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		$codigo_procedimiento_cons=$codigo_procedimiento;
		$id_unidad_organizacional=='Todos'?$id_unidad_organizacional='%':$id_unidad_organizacional;
		
		//se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		switch ($tipo_reporte) {
    			case 0://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			$reporte=new ReportDriver('RepPresupuestoUnidades.jasper','sss','pdf');
       			 break;
    			case 1://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('RepPresupuestoUnidades.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('RepPresupuestoUnidades.jasper','sss','html');
       			
      			break;
		}
        //$criterio_filtro=' u.id_usuario='.$id_usuario.' and r.fecha between '.$fecha_inicio.' and '.$fecha_fin." and r.codigo_procedimiento like ''$codigo_procedimiento'' ";
    //    $criterio_filtro=" u.id_usuario like '$id_usuario' and r.fecha between '$fecha_inicio' and '$fecha_fin' and r.codigo_procedimiento like '$codigo_procedimiento' ";
       
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_x_uniorg1.jasper');
		//$reporte->addParametroURL('sub_reporte2','report_transaccion_usuario_subreporte2.jasper');
		
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
			
		//$reporte->addParametro('criterio_filtro',$criterio_filtro);
	
		$reporte->runReporte();
	}
?>
