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
  			$estado=$_POST['estado'];
  			$id_fina_regi_prog_proy_acti=$_POST['id_fina_regi_prog_proy_acti'];
  			$gestion=$_POST['gestion'];
  			$fecha_desde=$_POST['txt_fecha_desde'];
  			$fecha_hasta=$_POST['txt_fecha_hasta'];
  			$estado_vigente_solicitud=$_POST['estado_vigente_solicitud'];
  			$tipo_adq=$_POST['tipo_adq'];
  			
		} else {
  			$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
  			$estado=$_GET['estado'];
  			$id_fina_regi_prog_proy_acti=$_GET['id_fina_regi_prog_proy_acti'];
  			$gestion=$_GET['gestion'];
  			$fecha_desde=$_GET['txt_fecha_desde'];
  			$fecha_hasta=$_GET['txt_fecha_hasta'];
  			$estado_vigente_solicitud=$_GET['estado_vigente_solicitud'];
  			$tipo_adq=$_GET['tipo_adq'];
		}
		
		 
		 switch ($estado) {
		case 'Pendientes':
 			$estado_cons=" and (solcom.estado_vigente_solicitud like 'borrador' or solcom.estado_vigente_solicitud like 'pre_aprobado' or solcom.estado_vigente_solicitud like 'pendiente_pre_aprobacion') ";	
 			
 		break;
 
		case 'Aprobados':
			$estado_cons=" and (solcom.estado_vigente_solicitud like 'aprobado' or solcom.estado_vigente_solicitud like 'en_proceso' or solcom.estado_vigente_solicitud like 'finalizado')";
		break;
		case 'Finalizados':
             $estado_cons=" and (solcom.estado_vigente_solicitud like 'finalizado')";
        break;
   		case 'Todos':
             $estado_cons=" and (solcom.estado_vigente_solicitud like '%')";
        break;

     }
        $criterio_filtro= $criterio_filtro ."  AND uniorg.id_unidad_organizacional like ''$id_unidad_organizacional'' and solcom.id_fina_regi_prog_proy_acti like ''$id_fina_regi_prog_proy_acti''
    										and solcom.gestion=$gestion 
    										and (solcom.fecha_reg>=''$txt_fecha_desde''AND solcom.fecha_reg<=''$txt_fecha_hasta'')
    										$estado_cons and solcom.estado_vigente_solicitud!=''anulado'' and  (select count(soldet.id_solicitud_compra) as total
 		from compro.tad_solicitud_compra_det   soldet
 		inner join compro.tad_solicitud_compra solcom1 on(solcom1.id_solicitud_compra=soldet.id_solicitud_compra)
 		where  solcom1.id_solicitud_compra = solcom.id_solicitud_compra)<>0 and tipadq.tipo_adq like ''$tipo_adq'' ";
     
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
			//se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		$reporte=new ReportDriver('reporte_solicitudes_adquisiciones12.jasper','compro','pdf');
		//$reporte=new ReportDriver('sub_reporte_1.jasper','compro','pdf');
		
		
		  $fecha_desde=date_create ($fecha_desde); 
          $fecha_desde=date_format( $fecha_desde,'m/d/Y');
           $fecha_hasta=date_create ($fecha_hasta); 
          $fecha_hasta=date_format( $fecha_hasta,'m/d/Y');
         
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		$reporte->addParametroURL('sub_reporte_1','sub_reporte_1.jasper');
		if($tipo_adq=='Servicio'){
		$reporte->addParametroURL('sub_reporte_2','sub_reporte_2.jasper');
		}else{
		$reporte->addParametroURL('sub_reporte_2','sub_reporte_item.jasper');
			
		}
		if($tipo_adq=='Servicio'){
			$titulo='SERVICIOS';
		}else{
			$titulo='BIENES';
		}
		//Se añade parametros necesarios para la generación del reporte
		$reporte->addParametro('titulo',$titulo);
		$reporte->addParametro('id_fina_regi_prog_proy_acti',$id_fina_regi_prog_proy_acti);
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional);
		$reporte->addParametro('estado_vigente_solicitud',$estado_cons);
		$reporte->addParametro('estado',$estado);
		$reporte->addParametro('gestion',$gestion,'Integer');
		//$reporte->addParametro('id_partida',$id_partida,'Integer');
    	$reporte->addParametro('fecha_inicio',$fecha_desde,'Date','MM/dd/yyyy');
		$reporte->addParametro('fecha_fin',$fecha_hasta,'Date','MM/dd/yyyy');
		$reporte->addParametro('tipo_adq',$tipo_adq);
		//$reporte->addParametro('id_partida',760,'Integer');		
		//Se hace correr el 
		
				
		$reporte->runReporte();
	}

?>