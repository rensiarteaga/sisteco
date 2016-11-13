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
  			$fecha_inicio=$_POST['fecha_inicio'];
  			$fecha_fin=$_POST['fecha_fin'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			$id_unidad_organizacional=$_POST['id_unidad_organizacional'];
  		
		} else {
  			$fecha_inicio=$_GET['fecha_inicio'];
  			$fecha_fin=$_GET['fecha_fin'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
		}
	/*	echo $id_unidad_organizacional;
		echo $fecha_inicio;
		echo $fecha_fin;
		exit;*/
		
  	/*	echo "fecha_inicio".$fecha_inicio;	
  		echo "fecha_fin".$fecha_fin;	
  		echo "tipo_reporte".$tipo_reporte;
  		echo "codigo_procedimiento".$codigo_procedimiento;
  		echo "nombre_usuario".$nombre_usuario;
  		exit;*/
  			
		//Clase necesaria para la generación de reporte  
		//$fecha_inicio="01/01/2011";
		//$fecha_fin="01/01/2012";
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		/*$codigo_procedimiento_cons=$codigo_procedimiento;
		$codigo_procedimiento=='Todos'?$codigo_procedimiento='%':$codigo_procedimiento;
		
		*///se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		switch ($tipo_reporte) {
    			case 0://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			$reporte=new ReportDriver('estadisticas_correspondencia_total.jasper','sss','pdf');
       			 break;
    			case 1://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('estadisticas_correspondencia_total.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('estadisticas_correspondencia_total.jasper','sss','xls');
       			
      			break;
		}
        //$criterio_filtro=' u.id_usuario='.$id_usuario.' and r.fecha between '.$fecha_inicio.' and '.$fecha_fin." and r.codigo_procedimiento like ''$codigo_procedimiento'' ";
       // $criterio_filtro=" u.id_usuario like '$id_usuario' and r.fecha between '$fecha_inicio' and '$fecha_fin' and r.codigo_procedimiento like '$codigo_procedimiento' ";
       
		//$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametroURL('SUBREPORT_DIR','estadisticas_correspondencia.jasper');
	//	$reporte->addParametroURL('sub_reporte2','report_transaccion_usuario_subreporte2.jasper');
		
		$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
		$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
		//$reporte->addParametro('codigo_procedimiento',$codigo_procedimiento_cons);
		
		
		//$reporte->addParametro('criterio_filtro',$criterio_filtro);
	
		$reporte->runReporte();
	}
?>
