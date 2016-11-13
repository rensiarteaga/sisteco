<?php
	session_start();
	//include_once('../../../../LibModeloPresupuesto.php');
	//$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDF_RepFlujoCaja.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_siet_cbte = $_POST['id_siet_cbte'];
	  		$id_siet_declara = $_POST['id_siet_declara'];
	  		$tipo_declara = $_POST['tipo_declara'];
	  		$reporte = $_POST['reporte'];
	  		$periodo = $_POST['periodo'];
	  		$gestion = $_POST['gestion'];
	 	} else {
			$id_siet_cbte = $_GET['id_siet_cbte'];
			$id_siet_declara = $_GET['id_siet_declara'];
			$tipo_declara = $_GET['tipo_declara'];
			$reporte = $_GET['reporte'];
			$periodo = $_GET['periodo'];
			$gestion = $_GET['gestion'];
			 
	  	}  
	  
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
			$tipo_reporte = 'pdf';
				if($reporte=='oec' ){
					$reporte=new ReportDriver('rep_x_oec.jasper','presto',$tipo_reporte);
				}
				else if($reporte=='cbte'){
					$reporte=new ReportDriver('rep_x_cbte.jasper','presto',$tipo_reporte);
				}else if($reporte=='flujo'){
					$reporte=new ReportDriver('rep_flujo_caja.jasper','presto',$tipo_reporte);
				    }
				    else if($reporte=='transferencias'){
					$reporte=new ReportDriver('rep_siet_transferencias.jasper','presto',$tipo_reporte);
				    }
				     else if($reporte=='extracto_bancario'){
					$reporte=new ReportDriver('rep_siet_extracto_bancario.jasper','presto',$tipo_reporte);
				    }
				     else if($reporte=='comprobantes_dec'){
					$reporte=new ReportDriver('rep_siet_cbte_comprobantes_faltantes.jasper','presto',$tipo_reporte);
				    }
				    else if($reporte=='comprobantes_sin_partida'){
				    	$reporte=new ReportDriver('rep_siet_cbte_no_asoc_partidas.jasper','presto',$tipo_reporte);
				    }
				     else if($reporte=='conc_fallida'){
				    	$reporte=new ReportDriver('rep_conc_fallida.jasper','presto',$tipo_reporte);
				    }else if($reporte=='conc_banc_cbte'){
				    	$reporte=new ReportDriver('rep_conciliacion_bancaria_cbtes.jasper','presto',$tipo_reporte);
				    }else if($reporte=='conc_banc_par'){
				    	$reporte=new ReportDriver('rep_conciliacion_bancaria_partida.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='conc_fallida_partida'){
				    	$reporte=new ReportDriver('rep_conc_fallida_partidas.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='seguimiento_fa'){
				    	$reporte=new ReportDriver('rep_siet_seguimiento_fa.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='division_fr'){
				    	$reporte=new ReportDriver('rep_div_fr.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='fa_faltantes'){
				    	$reporte=new ReportDriver('rep_siet_cbtes_fa_faltantes.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='dep_erroneo'){
				    	$reporte=new ReportDriver('rep_siet_cbtes_faltantes_caja.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='partidas_sin_oec'){
				    	$reporte=new ReportDriver('rep_siet_cbte_no_asoc_oec.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='conc_banc_oec'){
				    	$reporte=new ReportDriver('rep_conciliacion_bancaria_oec.jasper','presto',$tipo_reporte);
				    }elseif($reporte=='conc_fallida_oec'){
				    	$reporte=new ReportDriver('rep_conc_fallida_oec.jasper','presto',$tipo_reporte);
				    }else					    
				    {
					$reporte=new ReportDriver('rep_cbte_partida.jasper','presto',$tipo_reporte);
				    }
				
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
			
		$reporte->addParametro('pm_id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('pm_ip',$_SESSION['ss_ip']);
		$reporte->addParametro('pm_mac',$_SESSION['ss_mac']);
        $reporte->addParametro('pr_id_siet_declara',$id_siet_declara,'Integer');
		$reporte->addParametro('pr_id_siet_cbte',$id_siet_cbte);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
        $reporte->addParametro('pr_periodo',$periodo);
		$reporte->addParametro('pr_gestion',$gestion);
		$reporte->runReporte();
	}
?>
