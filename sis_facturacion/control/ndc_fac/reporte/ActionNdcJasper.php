<?php
	session_start();
	include_once('../../LibModeloFactur.php');
	//Clase necesaria para la generación de reporte
	include_once('../../../../lib/lib_modelo/ReportDriver.php');
	require('../../../../lib/phpqrcode/qrlib.php');
	
	$Custom = new cls_CustomDBFactur();
	$nombre_archivo = 'ActionNdcJasper.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_ndc=$_POST['id_ndc'];
			$id_gestion=$_POST['id_gestion'];
			$sw_rep=$_POST['sw_rep'];
		} else {
			$id_ndc=$_GET['id_ndc'];
			$id_gestion=$_GET['id_gestion'];
			$sw_rep=$_GET['sw_rep'];
  		}
		$tipo_reporte = 'pdf';
		$rutaAbs = trim(dirname(__FILE__)."/qrimage/");
		$id_ndcs = '0=0 AND NDC.id_ndc = '.$id_ndc;
		
		/*echo ('id_ndc '.$id_ndc);
		echo ('fil '.$id_ndcs);
		exit();*/
		
		$cant=10000000;
		$puntero=0;
		$sortdir='asc';
		
		if ($id_gestion < 15){
			$reporte=new ReportDriver('repfac_Facndc.jasper','sci',$tipo_reporte);
		}else{
			$res = $Custom->ListarNdcQR($cant,$puntero,$sortcol,$sortdir,$id_ndcs,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			//echo $Custom->query;exit;
			$data = $Custom->salida;
			//print_r($data);exit;
			if($res){
				foreach($data as $row)
				{
					if($row['sw_debito']=='si'){
						$qrstring = $row['nro_nit'].'|';
						$qrstring.= $row['ndc_numero'].'|';
						$qrstring.= $row['nro_autoriza'].'|';
						$qrstring.= $row['ndc_fecha'].'|';
						$qrstring.= $row['ndc_importe'].'|';
						$qrstring.= $row['ndc_importe'].'|';
						$qrstring.= $row['ndc_control'].'|';
						$qrstring.= $row['fac_nronit'].'|';
						$qrstring.= '0'.'|';
						$qrstring.= '0'.'|';
						$qrstring.= '0'.'|';
						$qrstring.= '0';
					}else{ //si no contiene credito fiscal (COBIJA)
						$qrstring = $row['nro_nit'].'|';
						$qrstring.= $row['ndc_numero'].'|';
						$qrstring.= $row['nro_autoriza'].'|';
						$qrstring.= $row['ndc_fecha'].'|';
						$qrstring.= $row['ndc_importe'].'|';
						$qrstring.= '0'.'|';
						$qrstring.= $row['ndc_control'].'|';
						$qrstring.= $row['fac_nronit'].'|';
						$qrstring.= '0'.'|';
						$qrstring.= '0'.'|';
						$qrstring.= $row['ndcc_importe'].'|';
						$qrstring.= '0';
					}
				}
			}
			//print_r($qrstring);exit;
			$fileName=trim($rutaAbs.$id_ndc.'-NDC.jpg');
			
			QRcode::png($qrstring,$fileName,QR_ECLEVEL_H);
			echo 'Archivo Generado';
			
			$reporte=new ReportDriver('repfac_Facndc_qr.jasper','sci',$tipo_reporte);
				
			$reporte->addParametro('imagen_qr',$fileName);
		}
		
		$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		
		if ($sw_rep == 1){
			$reporte->addParametro('imagen_fac1','../../../../lib/images/ndc-00.png');
		}
		if ($sw_rep == 2){
			$reporte->addParametro('imagen_fac1','../../../../lib/images/ndc-01.png');
		}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('id_ndc',$id_ndcs);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		$reporte->runReporte();
	}
?>
