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
  			$id_parametro_adquisicion=$_POST['id_parametro_adquisicion'];
  			$fecha_desde=$_POST['txt_fecha_desde'];
  			$fecha_hasta=$_POST['txt_fecha_hasta'];
  			$gestion=$_POST['gestion'];
  			$tipo_pres=$_POST['tipo_pres'];
  			$id_presupuesto=$_POST['id_presupuesto'];
  			$id_partida=$_POST['id_partida'];
  			$tipo_adq=$_POST['tipo_adq'];
  			
		} else {
			$id_parametro_adquisicion=$_GET['id_parametro_adquisicion'];
  			$fecha_desde=$_GET['txt_fecha_desde'];
  			$fecha_hasta=$_GET['txt_fecha_hasta'];
  			$gestion=$_GET['gestion'];
  			$tipo_pres=$_GET['tipo_pres'];
  			$id_presupuesto=$_GET['id_presupuesto'];
  			$id_partida=$_GET['id_partida'];
  			$tipo_adq=$_GET['tipo_adq'];
			
			
		}
		
		/*echo "id_parametro_adquisicion".$id_parametro_adquisicion;
  			echo "fecha_desde".$fecha_desde;
  			echo "fecha_hasta".$fecha_hasta;
  			echo "gestion".$gestion;
  			echo "tipo_pres".$tipo_pres;
  			echo "id_presupuesto".$id_presupuesto;
  			echo "id_partida".$id_partida;
  			echo "tipo_adq".$tipo_adq;
		exit;*/
		
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
			//se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		$reporte=new ReportDriver('reporte_procesos_en_curso.jasper','compro','pdf');
		//$reporte=new ReportDriver('sub_reporte_1.jasper','compro','pdf');
		
		
		  $fecha_desde=date_create ($fecha_desde); 
          $fecha_desde=date_format( $fecha_desde,'m/d/Y');
           $fecha_hasta=date_create ($fecha_hasta); 
          $fecha_hasta=date_format( $fecha_hasta,'m/d/Y');
         
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		$reporte->addParametroURL('sr_partidas','sub_reporte_partidas.jasper');
	//	if($tipo_adq=='Servicio'){
		$reporte->addParametroURL('sr_procesos','sub_reporte_procesos.jasper');
		//}else{
		//$reporte->addParametroURL('sub_reporte_2','sub_reporte_item.jasper');
			
		//}
		if($tipo_adq=='Servicio'){
			$titulo='SERVICIOS';
		}else{
			$titulo='BIENES';
		}
		//Se añade parametros necesarios para la generación del reporte
		$reporte->addParametro('i_tipo_pres',$tipo_pres);
		$reporte->addParametro('i_titulo',$titulo);
		$reporte->addParametro('i_b_fecha_inicio',$fecha_desde,'Date','MM/dd/yyyy');
		$reporte->addParametro('i_b_fecha_fin',$fecha_hasta,'Date','MM/dd/yyyy');
		$reporte->addParametro('i_b_gestion',$gestion,'Integer');
		$reporte->addParametro('b_tipo_adq',$tipo_adq);
	    $reporte->addParametro('b_id_presupuesto',$id_presupuesto);
		
	   // $reporte->addParametro('id_parametro_adquisicion',$id_parametro_adquisicion);
		
		//$reporte->addParametro('id_partida',$id_partida);
		
	//	$reporte->addParametro('estado_vigente_solicitud',$estado_cons);
	//	$reporte->addParametro('estado',$estado);
	
		//$reporte->addParametro('id_partida',$id_partida,'Integer');
    		
		//$reporte->addParametro('id_partida',760,'Integer');		
		//Se hace correr el 
		
				
		$reporte->runReporte();
	}

?>