<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFLibroRetenJasper.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_depto=$_POST['id_depto'];
  			$id_periodo_subsistema=$_POST['id_periodo'];
  			$id_moneda=$_POST['id_moneda'];
  			$id_usuario=$_POST['id_usuario'];
  			$sw_retencion=$_POST['sw_retencion'];
  			$nombre_resp=$_POST['desc_usuario'];
  			$doc_id=$_POST['doc_id'];
  			$desc_gestion=$_POST['desc_gestion'];
  			$periodo=$_POST['desc_periodo'];
  			$por_comprobante=$_POST['por_comprobante'];
  			$toda_gestion=$_POST['toda_gestion'];
  			$tipo_reporte=$_POST['tipo_reporte'];
		} else {
			$id_depto=$_GET['id_depto'];
  			$id_periodo_subsistema=$_GET['id_periodo'];
  			$id_moneda=$_GET['id_moneda'];
  			$id_usuario=$_GET['id_usuario'];
  			$sw_retencion=$_GET['sw_retencion'];
  			$nombre_resp=$_GET['desc_usuario'];
  			$doc_id=$_GET['doc_id'];
  			$desc_gestion=$_GET['desc_gestion'];
  			$periodo=$_GET['desc_periodo'];
  			$por_comprobante=$_GET['por_comprobante'];
  			$toda_gestion=$_GET['toda_gestion'];
  			$tipo_reporte=$_GET['tipo_reporte'];
  		}
		
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';
		
		if ($por_comprobante=='true'){
			$criterio_orden = 'COM.desc_comprobante, DOC.fecha_documento ';
		}else{
			$criterio_orden = 'DOC.fecha_documento, COM.desc_comprobante ';
		}
		
		if($toda_gestion=='true'){
			$hidden_ep_id_actividad = $desc_gestion;
		}else{
			$hidden_ep_id_actividad = '%';
		}
		
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
				$reporte=new ReportDriver('reportLib_reten_cbte.jasper','sci',$tipo_reporte);
			}else{
				$reporte=new ReportDriver('reportLib_reten.jasper','sci',$tipo_reporte);
			}
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
			$reporte->addParametro('id_depto',$id_depto);
			$reporte->addParametro('id_periodo_subsistema',$id_periodo_subsistema,'Integer');
			$reporte->addParametro('id_moneda',$id_moneda,'Integer');
			$reporte->addParametro('sw_retencion',$sw_retencion,'Integer');
			$reporte->addParametro('hidden_ep_id_actividad',$hidden_ep_id_actividad);
			$reporte->addParametro('criterio_orden',$criterio_orden);
			$reporte->addParametro('nombre_resp',utf8_encode($nombre_resp1));
			$reporte->addParametro('doc_id',$doc_id);
			$reporte->addParametro('desc_gestion',$desc_gestion);
			$reporte->addParametro('periodo',$periodo);
			$reporte->addParametro('razon_social',$razon_social);
			$reporte->addParametro('sucursal',$nombre);
			$reporte->addParametro('nit',$nit);
			$reporte->addParametro('direccion',$direccion);
			$reporte->runReporte();
		}else{
			$reporte=new ReportDriver('reportLib_reten_xls.jasper','sci',$tipo_reporte);
			$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
			$reporte->addParametro('id_depto',$id_depto);
			$reporte->addParametro('id_periodo_subsistema',$id_periodo_subsistema,'Integer');
			$reporte->addParametro('id_moneda',$id_moneda,'Integer');
			$reporte->addParametro('sw_retencion',$sw_retencion,'Integer');
			$reporte->addParametro('hidden_ep_id_actividad',$hidden_ep_id_actividad);
			$reporte->addParametro('criterio_orden',$criterio_orden);
			$reporte->runReporte();
		}
	}
?>
