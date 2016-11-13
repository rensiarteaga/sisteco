<?php
	session_start();
	include_once('../../LibModeloContabilidad.php');
	$Custom = new cls_CustomDBContabilidad();
	$nombre_archivo = 'ActionPDFDetalleAuditJasper.php';

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
			
			
			$id_moneda=$_POST['id_moneda'];
			$desc_moneda=$_POST['desc_moneda'];
			
			
			$sw_partida=$_POST['sw_partida'];
			
			$id_partida_inicial=$_POST['id_partida_inicial'];
			$id_partida_final=$_POST['id_partida_final'];
		
			$ids_partida=$_POST['ids_partida'];
			$desc_partida=$_POST['desc_partida'];
			$tipo_reg=$_POST['tipo_pres'];
			
			$sw_ppto=$_POST['sw_ppto'];
			$ids_ppto=$_POST['ids_ppto'];
		} else {
			$id_gestion=$_GET['id_gestion'];
			$id_depto=$_GET['id_depto'];
			$desc_depto=$_GET['desc_depto'];
			 
			$fecha_inicio=$_GET['fecha_inicio'];
			$fecha_final=$_GET['fecha_final'];
			$fecha_inicio_rep=$_GET['fecha_inicio_rep'];
			$fecha_final_rep=$_GET['fecha_final_rep'];
			
			
			$id_moneda=$_GET['id_moneda'];
			
			$desc_moneda=$_GET['desc_moneda'];
			
			
			$sw_partida=$_GET['sw_partida'];
			
			$id_partida_inicial=$_GET['id_partida_inicial'];
			$id_partida_final=$_GET['id_partida_final'];
			
			
			$desc_partida=$_GET['desc_partida'];
			$tipo_reg=$_GET['tipo_pres'];
			$sw_ppto=$_GET['sw_ppto'];
			$ids_ppto=$_GET['ids_ppto'];
			
  		}
		
  		//echo   $ids_ppto ;
  		/*$id_gestion.'depto:'.$id_depto.'desc_depto:'.	$desc_depto.'  fecha_ini: '.	$fecha_inicio.' feccha_fin: '.	
  		$fecha_final.' fecha_ini_rep:'.	$fecha_inicio_rep.' fecha_fin_rep: '.	$fecha_final_rep.' id_moneda: '.	$id_moneda.' desc_moneda: '. 
  		$desc_moneda.' sw_partida: '.		$sw_partida.' id_partida_ini: '.	$id_partida_inicial.' id_partida_fin: '.	$id_partida_final.' ids_partida: '.	$ids_partida
  		.' tipo_reg: '.		$tipo_reg. 'sw_ppto: '.$sw_ppto.' ids_ppto: '. $ids_ppto ;
  		
  		*/
  		//exit;
  			//Clase necesaria para la generación de reporte 
  		
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';

		
			$tipo_rep = 'pdf';
			
			$reporte=new ReportDriver('rep_detalle_global.jasper','sci',$tipo_rep);
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		//}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('eeff_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->addParametro('id_gestion',$id_gestion,'Integer');
		$reporte->addParametro('id_depto',$id_depto,'Integer');
		$reporte->addParametro('desc_depto',$desc_depto);
		 
		$reporte->addParametro('fecha_inicio',$fecha_inicio);
		$reporte->addParametro('fecha_final',$fecha_final);
		$reporte->addParametro('fecha_inicio_rep',$fecha_inicio_rep);
		$reporte->addParametro('fecha_final_rep',$fecha_final_rep);
		

		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('desc_moneda',$desc_moneda);
	
		$reporte->addParametro('sw_partida',$sw_partida);

		 
	
		$reporte->addParametro('id_partida_inicial',$id_partida_inicial,'Integer');
		$reporte->addParametro('id_partida_final',$id_partida_final,'Integer');
		
		$reporte->addParametro('tipo_pres',$tipo_reg);
		$reporte->addParametro('desc_partida','PARTIDA: '.UTF8_encode($desc_partida));
		$reporte->addParametro('sw_ppto',$sw_ppto);
		$reporte->addParametro('ids_ppto',$ids_ppto);
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		
		//echo $tipo_rep; exit;
		
		/*$reporte->addParametro('eeff_usuario','MZM');
		$reporte->addParametro('id_gestion',13,'Integer');
		$reporte->addParametro('id_depto',0,'Integer');
		$reporte->addParametro('desc_depto','Todos');
			
		
		$reporte->addParametro('fecha_inicio','2014-01-01');
		$reporte->addParametro('fecha_final','2014-12-31');
		
		$reporte->addParametro('fecha_inicio_rep','2014-01-01');
		$reporte->addParametro('fecha_final_rep','2014-12-31');
		
		
		$reporte->addParametro('id_moneda',1,'Integer');
		$reporte->addParametro('desc_moneda','Bs.');
		
		$reporte->addParametro('sw_partida','rango');
		
			
		
		$reporte->addParametro('id_partida_inicial',4841,'Integer');
		$reporte->addParametro('id_partida_final',4841,'Integer');
		$reporte->addParametro('tipo_pres','Gasto');
		$reporte->addParametro('desc_partida',UTF8_encode($desc_partida));*/
		
		
		
		$reporte->runReporte();
	}
?>
