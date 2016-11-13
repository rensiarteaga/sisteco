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
  			$id_presupuesto=$_POST['id_presupuesto'];
  			$nombre_moneda=$_POST['desc_moneda'];
  			
  			
		} else {
  			$id_moneda=$_GET['id_moneda'];
  			$tipo_pres=$_GET['tipo_pres'];
  			$id_parametro=$_GET['id_parametro'];
  			$id_presupuesto=$_GET['id_presupuesto'];
  			$nombre_moneda=$_POST['desc_moneda'];
  			}
		
  
		//Clase necesaria para la generación de reporte  
		/*echo "id_moneda-".$id_moneda;
		echo "tipo_pres-".$tipo_pres;
		echo "id_parametro".$id_parametro;
		echo "id_presupuesto".$id_presupuesto;
		exit;*/
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$codigo_procedimiento_cons=$codigo_procedimiento;
		 /*if ($id_unidad_organizacional=='%')
		 {
		 	  switch ($tipo_reporte) {
    			case 0://pdf
       			//$reporte=new ReportDriver('report51.jasper','sss','pdf');
       			$reporte=new ReportDriver('indice_solicitudes_x_unidad.jasper','sss','pdf');
       			 break;
    			case 1://word
       			//$reporte=new ReportDriver('report51.jasper','sss','rtf');
       			$reporte=new ReportDriver('indice_solicitudes_x_unidad.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			//$reporte=new ReportDriver('report51.jasper','sss','xls');
     			$reporte=new ReportDriver('indice_solicitudes_x_unidad.jasper','sss','xls');
       			
      			break;
				}
				$reporte->addParametroURL('SUBREPORT_DIR','indice_solicitudes_x_unidad_total.jasper');
			
				$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
				$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');
		}else{*/
			  /*switch ($tipo_reporte) {
    			case 0://pdf*/
       			$reporte=new ReportDriver('presupuesto_ofer_ejecutado_sum_total.jasper','sss','pdf');
       			//break;
    			/*case 1://word
       			$reporte=new ReportDriver('indice_solicitudes_x_uo.jasper','sss','rtf');
       			
       			 break;
    			case 2://excel
     			$reporte=new ReportDriver('indice_solicitudes_x_uo.jasper','sss','xls');
       			
      			break;
				}*/
				$reporte->addParametroURL('SUBREPORT_DIR','presupuesto_ofer_ejecutado_grafico_x_pres.jasper');
				$reporte->addParametroURL('SUBREPORT_TABLA','presupuesto_ofer_ejecutado_tabla_x_pres.jasper');
			   // $reporte->addParametroURL('SUBREPORT1','indice_solicitudes_x_uo_tortas.jasper');
				
		//}/**/
		
		/*$criterio_filtro="(select id_partida_presupuesto
                                                             from presto.tpr_partida_presupuesto parpre
                                                             where parpre.id_presupuesto in (select id_presupuesto
                                                                                            from presto.tpr_presupuesto
                                                                                            where
                                                                                            tipo_pres=$tipo_pres and
                                                                                            id_parametro=$id_parametro and
                                                                                            id_presupuesto like ('$id_presupuesto'))
                                                               ) and id_moneda=$id_moneda";
*/		//$titulo='Presupuesto Formulado vs Ejecutado';
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		
		$reporte->addParametro('id_presupuesto',$id_presupuesto);
		
		$reporte->addParametro('tipo_pres',$tipo_pres,'Integer');
		
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('moneda',$nombre_moneda);
		
		$reporte->runReporte();
	}
?>
