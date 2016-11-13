<?php

session_start();

include_once("../../LibModeloTesoreria.php");


$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionPDFRendicionVerificacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
/*echo "down down".utf8_decode($_GET['fecha_desde']);
exit; */

if($_SESSION['autentificado']=="SI")
{		
		$cant = 100000;
		$puntero = 0;
		$sortcolCab = 'CUEDOC.id_presupuesto';	
		$sortcol = 'CUEDOC.id_partida, CUEDOC.id_presupuesto';
		$sortcolS = 'partidS.codigo_partida, presupS.desc_presupuesto';
		$sortcolR = 'partidR.codigo_partida, presupR.desc_presupuesto';
		$sortcolR2 = 'partid.codigo_partida, presup.desc_presupuesto';	
		$sortdir = 'desc';
		 
		$cab_rendicion_verificacion = $Custom-> ListarReporteCabRendicionVerificacion($cant,$puntero,$sortcolCab,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cuenta_doc);
		$_SESSION['PDF_cab_rendicion_verificacion']=$Custom->salida;			
		
		$det_solicitudes_ampliaciones = $Custom-> ListarReporteDetSolicitudesAmpliaciones($cant,$puntero,$sortcolS,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cuenta_doc);
		$_SESSION['PDF_det_solicitudes_ampliaciones']=$Custom->salida;
		
		$det_rendiciones_anteriores = $Custom-> ListarReporteDetRendicionesAnteriores($cant,$puntero,$sortcolR,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cuenta_doc);
		$_SESSION['PDF_det_rendiciones_anteriores']=$Custom->salida;
		
		$det_rendicion_verificacion = $Custom-> ListarReporteDetRendicionVerificacion($cant,$puntero,$sortcolR2,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cuenta_doc);
		$_SESSION['PDF_det_rendicion_verificacion']=$Custom->salida;
		
		header("location: ../../../vista/solicitud_viaticos2/PDFRendicionVerificacion.php");	
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>