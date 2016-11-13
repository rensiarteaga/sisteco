<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFEeffComJasper.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_gestion=$_POST['id_gestion'];
			$id_depto=$_POST['id_depto'];
			$desc_depto=$_POST['desc_depto'];
			 
			$fecha_inicio=$_POST['fecha_inicio'];
			$fecha_final=$_POST['fecha_final'];
			$fecha_inicio_rep=$_POST['fecha_inicio_rep'];
			$fecha_final_rep=$_POST['fecha_final_rep'];
			
			$sw_estado_cbte=$_POST['sw_estado_cbte'];
			$sw_actualizacion=$_POST['sw_actualizacion'];
			$id_moneda=$_POST['id_moneda'];
			$desc_moneda=$_POST['desc_moneda'];
			
			$sw_cuenta=$_POST['sw_cuenta'];
			$sw_auxiliar=$_POST['sw_auxiliar'];
			$sw_partida=$_POST['sw_partida'];
			$sw_epe=$_POST['sw_epe'];
			$sw_uo=$_POST['sw_uo'];
			$sw_ot=$_POST['sw_ot'];
			 
			$id_cuenta_inicial=$_POST['id_cuenta_inicial'];
			$id_cuenta_final=$_POST['id_cuenta_final'];
			$id_auxiliar_inicial=$_POST['id_auxiliar_inicial'];
			$id_auxiliar_final=$_POST['id_auxiliar_final'];
			$id_partida_inicial=$_POST['id_partida_inicial'];
			$id_partida_final=$_POST['id_partida_final'];
			$id_epe_inicial=$_POST['id_epe_inicial'];
			$id_epe_final=$_POST['id_epe_final'];
			$id_uo_inicial=$_POST['id_uo_inicial'];
			$id_uo_final=$_POST['id_uo_final'];
			$id_ot_inicial=$_POST['id_ot_inicial'];
			$id_ot_final=$_POST['id_ot_final'];
			
			$ids_cuenta=$_POST['ids_cuenta'];
			$ids_partida=$_POST['ids_partida'];
			$ids_auxiliar=$_POST['ids_auxiliar'];
			$ids_epe=$_POST['ids_epe'];
			$ids_uo=$_POST['ids_uo'];
			$ids_ot=$_POST['ids_ot'];
			
			$tipo_reporte=$_POST['tipo_reporte'];
			$sw_orden=$_POST['sw_orden'];
		} else {
			$id_gestion=$_GET['id_gestion'];
			$id_depto=$_GET['id_depto'];
			$desc_depto=$_GET['desc_depto'];
			 
			$fecha_inicio=$_GET['fecha_inicio'];
			$fecha_final=$_GET['fecha_final'];
			$fecha_inicio_rep=$_GET['fecha_inicio_rep'];
			$fecha_final_rep=$_GET['fecha_final_rep'];
			
			$sw_estado_cbte=$_GET['sw_estado_cbte'];
			$sw_actualizacion=$_GET['sw_actualizacion'];
			$id_moneda=$_GET['id_moneda'];
			$desc_moneda=$_GET['desc_moneda'];
			
			$sw_cuenta=$_GET['sw_cuenta'];
			$sw_auxiliar=$_GET['sw_auxiliar'];
			$sw_partida=$_GET['sw_partida'];
			$sw_epe=$_GET['sw_epe'];
			$sw_uo=$_GET['sw_uo'];
			$sw_ot=$_GET['sw_ot'];
			 
			$id_cuenta_inicial=$_GET['id_cuenta_inicial'];
			$id_cuenta_final=$_GET['id_cuenta_final'];
			$id_auxiliar_inicial=$_GET['id_auxiliar_inicial'];
			$id_auxiliar_final=$_GET['id_auxiliar_final'];
			$id_partida_inicial=$_GET['id_partida_inicial'];
			$id_partida_final=$_GET['id_partida_final'];
			$id_epe_inicial=$_GET['id_epe_inicial'];
			$id_epe_final=$_GET['id_epe_final'];
			$id_uo_inicial=$_GET['id_uo_inicial'];
			$id_uo_final=$_GET['id_uo_final'];
			$id_ot_inicial=$_GET['id_ot_inicial'];
			$id_ot_final=$_GET['id_ot_final'];
			
			$ids_cuenta=$_GET['ids_cuenta'];
			$ids_partida=$_GET['ids_partida'];
			$ids_auxiliar=$_GET['ids_auxiliar'];
			$ids_epe=$_GET['ids_epe'];
			$ids_uo=$_GET['ids_uo'];
			$ids_ot=$_GET['ids_ot'];
			
			$tipo_reporte=$_GET['tipo_reporte'];
			$sw_orden=$_GET['sw_orden'];
  		}
		
		/*echo ('id_gestion'.$id_gestion);
		echo ('id_depto'.$id_depto);
		 
		echo ('fecha_inicio'.$fecha_inicio);
		echo ('fecha_final'.$fecha_final);
		echo ('fecha_inicio_rep'.$fecha_inicio_rep);
		echo ('fecha_final_rep'.$fecha_final_rep);
		
		echo ('sw_estado_cbte'.$sw_estado_cbte);
		echo ('sw_actualizacion'.$sw_actualizacion);
		echo ('id_moneda'.$id_moneda);
		echo ('desc_moneda'.$desc_moneda);
		echo ('sw_orden'.$sw_orden);
		
		echo ('sw_cuenta'.$sw_cuenta);
		echo ('sw_auxiliar'.$sw_auxiliar);
		echo ('sw_partida'.$sw_partida);
		echo ('sw_epe'.$sw_epe);
		echo ('sw_uo'.$sw_uo);
		echo ('sw_ot'.$sw_ot);
		 
		echo ('id_cuenta_inicial'.$id_cuenta_inicial);
		echo ('id_cuenta_final'.$id_cuenta_final);
		echo ('id_auxiliar_inicial'.$id_auxiliar_inicial);
		echo ('id_auxiliar_final'.$id_auxiliar_final);
		echo ('id_partida_inicial'.$id_partida_inicial);
		echo ('id_partida_final'.$id_partida_final);
		echo ('id_epe_inicial'.$id_epe_inicial);
		echo ('id_epe_final'.$id_epe_final);
		echo ('id_uo_inicial'.$id_uo_inicial);
		echo ('id_uo_final'.$id_uo_final);
		echo ('id_ot_inicial'.$id_ot_inicial);
		echo ('id_ot_final'.$id_ot_final);
	    exit();*/
	    
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';

		if($tipo_reporte=='xls'){
			$reporte=new ReportDriver('repeeff_Cuenta_xls.jasper','sci',$tipo_reporte);
		}else{
			$tipo_rep = 'pdf';
			if($tipo_reporte=='pdf1' or $tipo_reporte=='pdf2'){
				$reporte=new ReportDriver('repeeff_Cuenta.jasper','sci',$tipo_rep);
			}
			if($tipo_reporte=='pdf3'){
				$reporte=new ReportDriver('repeeff_Cuenta_ppto.jasper','sci',$tipo_rep);
			}
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('eeff_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->addParametro('id_gestion',$id_gestion,'Integer');
		$reporte->addParametro('id_depto',$id_depto,'Integer');
		$reporte->addParametro('desc_depto',$desc_depto);
		
		$reporte->addParametro('fecha_inicio',$fecha_inicio);
		$reporte->addParametro('fecha_final',$fecha_final);
		$reporte->addParametro('fecha_inicio_rep',$fecha_inicio_rep);
		$reporte->addParametro('fecha_final_rep',$fecha_final_rep);
		
		$reporte->addParametro('sw_estado_cbte',$sw_estado_cbte,'Integer');
		$reporte->addParametro('sw_actualizacion',$sw_actualizacion);
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('desc_moneda',$desc_moneda);
		$reporte->addParametro('sw_orden',$sw_orden);
		
		$reporte->addParametro('sw_cuenta',$sw_cuenta);
		$reporte->addParametro('sw_auxiliar',$sw_auxiliar);
		$reporte->addParametro('sw_partida',$sw_partida);
		$reporte->addParametro('sw_epe',$sw_epe);
		$reporte->addParametro('sw_uo',$sw_uo);
		$reporte->addParametro('sw_ot',$sw_ot);
		 
		$reporte->addParametro('id_cuenta_inicial',$id_cuenta_inicial,'Integer');
		$reporte->addParametro('id_cuenta_final',$id_cuenta_final,'Integer');
		$reporte->addParametro('id_auxiliar_inicial',$id_auxiliar_inicial,'Integer');
		$reporte->addParametro('id_auxiliar_final',$id_auxiliar_final,'Integer');
		$reporte->addParametro('id_partida_inicial',$id_partida_inicial,'Integer');
		$reporte->addParametro('id_partida_final',$id_partida_final,'Integer');
		$reporte->addParametro('id_epe_inicial',$id_epe_inicial,'Integer');
		$reporte->addParametro('id_epe_final',$id_epe_final,'Integer');
		$reporte->addParametro('id_uo_inicial',$id_uo_inicial,'Integer');
		$reporte->addParametro('id_uo_final',$id_uo_final,'Integer');
		$reporte->addParametro('id_ot_inicial',$id_ot_inicial,'Integer');
		$reporte->addParametro('id_ot_final',$id_ot_final,'Integer');
		
		$reporte->addParametro('ids_cuenta',$ids_cuenta);
		$reporte->addParametro('ids_auxiliar',$ids_auxiliar);
		$reporte->addParametro('ids_partida',$ids_partida);
		$reporte->addParametro('ids_epe',$ids_epe);
		$reporte->addParametro('ids_uo',$ids_uo);
		$reporte->addParametro('ids_ot',$ids_ot);
		
		if($tipo_reporte=='pdf1'){
			$sw_ctapar = 'A';
			$reporte->addParametro('sw_ctapar',$sw_ctapar);
		}
		if($tipo_reporte=='pdf2'){
			$sw_ctapar = 'B';
			$reporte->addParametro('sw_ctapar',$sw_ctapar);
		}
		$reporte->runReporte();
	}
?>
