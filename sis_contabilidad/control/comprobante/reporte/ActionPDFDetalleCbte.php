<?php
session_start();
include_once('../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFDetalleCbte.php';

if (! isset ( $_SESSION ['autentificado'] )) {
	$_SESSION ['autentificado'] = "NO";
}

if ($_SESSION ['autentificado'] == "SI") {
	$cant = 100000;
	$puntero = 0;
	$sortcol = '';
	$sortdir = 'asc';
	
	$_SESSION ['PDF_id_parametro'] = utf8_decode ( $_GET ['id_parametro'] );
	$_SESSION ['PDF_id_moneda'] = utf8_decode ( $_GET ['id_moneda'] );
	$_SESSION ['PDF_id_deptos'] = utf8_decode ( $_GET ['id_deptos'] );
	$_SESSION ['PDF_fecha_ini'] = utf8_decode ( $_GET ['fecha_ini'] );
	$_SESSION ['PDF_fecha_fin'] = utf8_decode ( $_GET ['fecha_fin'] );
		
	header ( 'location:XLSDetalleCbte.php' );
} else {
	$resp = new cls_manejo_mensajes ( true, '401' );
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = 'ORIGEN = $nombre_archivo';
	$resp->proc = 'PROC = $nombre_archivo';
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje ();
	exit ();

}
?>