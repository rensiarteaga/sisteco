<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionListarDocumentoImporte.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  			$id_periodo_subsistema=$_POST['m_periodo'];
  			$id_depto=$_POST['id_depto'];
  			$id_moneda=$_POST['id_moneda'];
  			$tipo_reporte=$_POST['tipo_reporte'];
  			$periodo=$_POST['desc_periodo'];
  			$sw_credito_debito=$_POST['sw_debito_credito'];
  			$nombre_resp=$_POST['desc_usuario'];
  			$desc_depto=$_POST['desc_depto'];
  			$doc_id=$_POST['doc_id'];
  			$desc_gestion=$_POST['desc_gestion'];
  			$id_usuario=$_POST['id_usuario'];
  			$tipo_documento=$_POST['tipo_documento'];
  			$toda_gestion=$_POST['toda_gestion'];
  			$por_comprobante=$_POST['por_comprobante'];
  			$ndc=$_POST['ndc'];
		} else {
  			$id_periodo_subsistema=$_GET['m_periodo'];
  			$id_depto=$_GET['id_depto'];
  			$id_moneda=$_GET['id_moneda'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  			$periodo=$_GET['desc_periodo'];
  			$sw_credito_debito=$_GET['sw_debito_credito'];
  			$nombre_resp=$_GET['desc_usuario'];
  			$desc_depto=$_GET['desc_depto'];
  			$doc_id=$_GET['doc_id'];
  			$desc_gestion=$_GET['desc_gestion'];
  			$id_usuario=$_GET['id_usuario'];
  			$tipo_documento=$_GET['tipo_documento'];
  			$toda_gestion=$_GET['toda_gestion'];
  			$por_comprobante=$_GET['por_comprobante'];
  			$ndc=$_GET['ndc'];
  		}
		
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';
			
		if($sw_debito_credito==1){
			if ($por_comprobante=='true'){
				$criterio_orden = 'COM.desc_comprobante,DOC.fecha_documento ';
			}else{
				$criterio_orden = 'DOC.fecha_documento, COM.desc_comprobante ';
			}
			if($tipo_reporte=='csv'){$criterio_orden = 'DOC.fecha_documento, COM.desc_comprobante ';}
			$tipo_documento = 'sd';
			$hidden_ep_id_proyecto = '1';
		}
		if($sw_debito_credito==2){
			if ($por_comprobante=='true'){
				$criterio_orden = 'COM.desc_comprobante,DOC.nro_autorizacion, DOC.fecha_documento, DOC.nro_documento '; 
			}else{
				$criterio_orden = 'DOC.nro_autorizacion, DOC.fecha_documento, DOC.nro_documento '; 
			}
			if($tipo_reporte=='csv'){$criterio_orden = 'nro_autorizacion, DOC.fecha_documento, DOC.nro_documento ';}
			$hidden_ep_id_proyecto = '2';
		}
	    
		if($toda_gestion=='true'){
			$hidden_ep_id_actividad = $desc_gestion;
		}else{
			$hidden_ep_id_actividad = '%';
		}
		
		/* if ($_SESSION["ss_id_usuario"]==120) {echo $tipo_documento; ('hidden_ep_id_actividad' .$hidden_ep_id_actividad);
	    echo ('hidden_ep_id_proyecto'.$hidden_ep_id_proyecto);
	    echo ('tipo_reporte'.$tipo_reporte);
		echo ('id_moneda'.$id_moneda);
		echo ('sw_credito_debito'.$sw_credito_debito);
		echo ('id_depto'.$id_depto);
		echo ('id_periodo_subsistema'.$id_periodo_subsistema);
		echo ('nombre'.$nombre);
		echo ('tipo_documento'.$tipo_documento);
		echo ('criterio_orden'.$criterio_orden);
		echo ('razon_social'.$razon_social);
		echo ('nit'.$nit);
		echo ('direccion'.$direccion);
		echo ('doc_id'.$doc_id);	
		echo ('id_depto'.$id_depto);
		echo ('id_periodo_subsistema'.$id_periodo_subsistema);
		echo ('id_moneda'.$id_moneda);
		echo ('periodo'.$periodo);
		echo ('sw_credito_debito'.$sw_credito_debito);
		echo ('nombre_resp'.utf8_encode($nombre_resp1));
		echo ('departamento'.$desc_depto);
		echo ('desc_gestion'.$desc_gestion);
		echo ('nombre_usuario'.$_SESSION['ss_nombre_usuario']);
		 
		 }
		exit;*/
		//echo 'id_proy:'.$hidden_ep_id_proyecto.' id_act:'.$hidden_ep_id_actividad; exit;
		if($tipo_reporte!='xls' and $tipo_reporte!='csv'){
			//Aqui obtendre los datos de la cabecera
			$DocumentosValCab=$Custom->ListarCabLibroCompraVenta($cant,$puntero,$sortcol,$sortdir,'0=0 AND id_usuario='.$id_usuario,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$_GET['id_moneda'],$sw_credito_debito,$id_depto,$tipo_documento);
			foreach ($Custom->salida as $f){
				$nombre=$f['nombre'];
				$razon_social=$f['razon_social'];
				$nit=$f['nit'];
				$direccion=$f['direccion'];
				$nombre_resp1=$f['nombre_resp'];	
			}
			
			if ($por_comprobante=='true'){
				if($sw_debito_credito==1){
					
					if($desc_gestion<2016){
						
						$reporte=new ReportDriver('__28feb2016_reportLib_comp_cbte.jasper','sci',$tipo_reporte);
					}else{ 
						if($ndc=='no'){
							$reporte=new ReportDriver('reportLib_comp_cbte.jasper','sci',$tipo_reporte);
						}else{ 
							$sw_credito_debito=7;
							$reporte=new ReportDriver('reportLib_comp_ndc_cbte.jasper','sci',$tipo_reporte);
						}
					}
				}else{
					if($ndc=='no'){
						$reporte=new ReportDriver('reportLib_venta_cbte.jasper','sci',$tipo_reporte);}
					else{
						$sw_credito_debito=8;
						$reporte=new ReportDriver('reportLib_comp_ndc_cbte.jasper','sci',$tipo_reporte);
					}
				}
			}else{
				
				if($sw_debito_credito==1){
					if($desc_gestion<2016){
						
						$reporte=new ReportDriver('__11mar2016_reportLib_comp.jasper','sci',$tipo_reporte);
					}else{
						if($ndc=='no'){
						    $reporte=new ReportDriver('reportLib_comp.jasper','sci',$tipo_reporte);
						}else{
							$sw_credito_debito=7;
							$reporte=new ReportDriver('reportLib_comp_ndc.jasper','sci',$tipo_reporte);
						}
					} 
				}else{ 
					if($ndc=='no'){
						$reporte=new ReportDriver('reportLib_venta.jasper','sci',$tipo_reporte);
					}else{
						$sw_credito_debito=8;
						$reporte=new ReportDriver('reportLib_comp_ndc.jasper','sci',$tipo_reporte);
					}
				}
			}
			$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
			//$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			$reporte->addParametro('criterio_orden',$criterio_orden);
			$reporte->addParametro('id_depto',$id_depto);
			$reporte->addParametro('id_periodo_subsistema',$id_periodo_subsistema,'Integer');
			$reporte->addParametro('id_moneda',$id_moneda,'Integer');
			$reporte->addParametro('sw_credito_debito',$sw_credito_debito,'Integer');
			$reporte->addParametro('tipo_documento',$tipo_documento);
			$reporte->addParametro('hidden_ep_id_actividad',$hidden_ep_id_actividad);
			$reporte->addParametro('desc_gestion',$desc_gestion);
			$reporte->addParametro('periodo',$periodo);
			$reporte->addParametro('razon_social',$razon_social);
			$reporte->addParametro('nombre',$nombre);
			$reporte->addParametro('nit',$nit);
			$reporte->addParametro('direccion',$direccion);
			$reporte->addParametro('nombre_resp',utf8_encode($nombre_resp1));
			$reporte->addParametro('doc_id',$doc_id);	
			$reporte->runReporte();
		}else{
			if($tipo_reporte=='xls'){
				if($sw_debito_credito==1){
					if($ndc=='no'){
						$reporte=new ReportDriver('reportLib_comp_xls.jasper','sci',$tipo_reporte);
					}else{
						$sw_credito_debito=7;
						$reporte=new ReportDriver('reportLib_comp_ndc_xls.jasper','sci',$tipo_reporte);
					} 
				}else{
					if($ndc=='no'){
						$reporte=new ReportDriver('reportLib_venta_xls.jasper','sci',$tipo_reporte);
					}else{
						$sw_credito_debito=8;
						$reporte=new ReportDriver('reportLib_comp_ndc_xls.jasper','sci',$tipo_reporte);
					}
				}
			}else{ 
				if($sw_debito_credito==1){
					if($ndc=='no'){
						$reporte=new ReportDriver('reportLib_comp_txt.jasper','sci',$tipo_reporte);
					}else{
						$sw_credito_debito=7;
						$reporte=new ReportDriver('reportLib_comp_ndc_txt.jasper','sci',$tipo_reporte);
					} 
				}else{
					if($ndc=='no'){
						if($tipo_documento=='sin_debito'){ 
							$reporte=new ReportDriver('reportLib_venta_sd_txt.jasper','sci',$tipo_reporte);
						}else{
						
							$reporte=new ReportDriver('reportLib_venta_txt.jasper','sci',$tipo_reporte);
						}
					}else{
						$sw_credito_debito=8;
						$reporte=new ReportDriver('reportLib_comp_ndc_txt.jasper','sci',$tipo_reporte);
					}
				}
			}
			$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
			$reporte->addParametro('tipo_documento',$tipo_documento);
			$reporte->addParametro('criterio_orden',$criterio_orden);
			$reporte->addParametro('id_depto',$id_depto);
			$reporte->addParametro('id_periodo_subsistema',$id_periodo_subsistema,'Integer');
			$reporte->addParametro('id_moneda',$id_moneda,'Integer');
			$reporte->addParametro('sw_credito_debito',$sw_credito_debito,'Integer');
			$reporte->addParametro('hidden_ep_id_actividad',$hidden_ep_id_actividad);
			if($tipo_reporte=='csv'){$reporte->addParametro('hidden_ep_id_proyecto',$hidden_ep_id_proyecto);}
			$reporte->runReporte();
		}
	}
?>
