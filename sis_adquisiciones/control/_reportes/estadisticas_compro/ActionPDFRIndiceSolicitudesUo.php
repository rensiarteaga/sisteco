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
  			$fecha_inicio=$_POST['fecha_ini'];
  			$fecha_fin=$_POST['fecha_fin'];
  			$id_unidad_organizacional=$_POST['id_unidad_organizacional'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			$id_categoria_adq=$_POST['id_categoria_adq'];
  			$tipo_impresion=$_POST['tipo_impresion'];
			$id_depto=$_POST['id_depto'];
			$reporte=$_POST['reporte'];
  			
  			
		} else {
  			$fecha_inicio=$_GET['fecha_ini'];
  			$fecha_fin=$_GET['fecha_fin'];
  			$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$id_categoria_adq=$_GET['id_categoria_adq'];
  			$tipo_impresion=$_GET['tipo_impresion'];
			$id_depto=$_GET['id_depto'];
			$reporte=$_GET['reporte'];
			$id_categoria_adq=$_GET['id_categoria_adq'];
  		}
		
  
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		/*echo "id_depto".$id_depto;
		echo "id_unidad_organizacional".$id_unidad_organizacional;
		echo "id_categoria_adq".$id_categoria_adq;
		echo "tipo_reporte".$tipo_reporte;*/
		
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		 if (($id_unidad_organizacional=='%'||$id_depto=='%') && $tipo_reporte =='0')
		 {
		 	  switch ($tipo_impresion) {
    			case 0://pdf
       			$reporte=new ReportDriver('indice_solicitudes_uo_depto_gral.jasper','sss','pdf');
       			 break;
    			case 1://word
       			$reporte=new ReportDriver('indice_solicitudes_uo_depto_gral.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			$reporte=new ReportDriver('indice_solicitudes_uo_depto_gral.jasper','sss','xls');
       			
      			break;
				}
				$reporte->addParametroURL('SUBREPORT_BARRAS','indice_solicitudes_uo_depto_gral_barras.jasper');
			    $reporte->addParametroURL('SUBREPORT_TABLA','indice_solicitudes_uo_depto_gral_tabla.jasper');
				$reporte->addParametroURL('SUBREPORT_TORTAS','indice_solicitudes_uo_depto_gral_tortas.jasper');
				
					if (is_null($id_unidad.organizacional)||$id_unidad_organizacional==''){
				     $id_unidad_organizacional=$id_depto;
					 $criterio_filtro='depto';
					 $titulo='DEPARTAMENTOS';
					
				}else 
				{
					$id_unidad_organizacional=$id_unidad_organizacional;
					$criterio_filtro='uo';
					 $titulo='UNIDADES ORGANIZACIONALES';
					
				}
				
				
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
		$reporte->addParametro('id_categoria_adq',$id_categoria_adq);
		$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
		$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');
		$reporte->addParametro('criterio_filtro',$criterio_filtro);
		$reporte->addParametro('titulo',$titulo);
				/*$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
				$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');*/  
		}/*else  if ($tipo_reporte=='2') { 
			  switch ($tipo_impresion) {
    			case 0://pdf
       			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','pdf');
       			 break;
    			case 1://word
       			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','xls');
       			
      			break;
				}
				$reporte->addParametroURL('SUBREPORT_DIR','indice_solicitudes_x_uo_barras_dept.jasper');
			    $reporte->addParametroURL('SUBREPORT_TABLA','indice_solicitudes_x_uo_modalidad_tabla_dept.jasper');
				
		}*/else{
			  switch ($tipo_impresion) {
    			case 0://pdf
       			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','pdf');
       			 break;
    			case 1://word
       			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			$reporte=new ReportDriver('Rindice_solicitudes_x_uo_dept.jasper','sss','xls');
       			
      			break;
				}
				$reporte->addParametroURL('SUBREPORT_DIR','indice_solicitudes_x_uo_barras_dept.jasper');
			    $reporte->addParametroURL('SUBREPORT_TABLA','indice_solicitudes_x_uo_modalidad_tabla_dept.jasper');
				
				if (is_null($id_unidad.organizacional)||$id_unidad_organizacional==''){
				     $id_unidad_organizacional=$id_depto;
					 $criterio_filtro='depto';
					 $titulo='DEPARTAMENTOS';
					
				}else 
				{
					$id_unidad_organizacional=$id_unidad_organizacional;
					$criterio_filtro='uo';
					$titulo='UNIDADES ORGANIZACIONALES';
					
				}
				
				
			    $reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
				
		$reporte->addParametro('id_categoria_adq',$id_categoria_adq);
		$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
		$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');
		$reporte->addParametro('criterio_filtro',$criterio_filtro);
		$reporte->addParametro('titulo',$titulo);
		}
		
		$reporte->runReporte();
	}
?>
