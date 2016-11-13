<?php
session_start();
include_once("../../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionPDFEstadoSolEfe.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'CUDOC.id_caja';	
	$sortdir = 'desc';
	$criterio_filtro='0=0';
		
			$id_empleado = $Custom-> ListarRepEstSolicitudEfectivos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
			              
			$_SESSION['PDF_estado_cuenta_efectivo']=$Custom->salida;
				
			header("location:../../../vista/_reportes/estado_cuenta/PDFEstadoCuentaEfectivo.php");
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