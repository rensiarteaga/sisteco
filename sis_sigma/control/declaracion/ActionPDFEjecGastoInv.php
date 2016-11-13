<?php
session_start ();
include_once ("../LibModeloSigma.php");

$Custom = new cls_CustomDBSigma ( );
$nombre_archivo = 'ActionPDFEjecGastoInv.php';

if (! isset ( $_SESSION ['autentificado'] )) {
	$_SESSION ['autentificado'] = "NO";
}

if ($_SESSION ['autentificado'] == "SI") {
	$cant = 100000;
	$puntero = 0;
	$sortcol = '';
	$sortdir = 'asc';
	
	$_SESSION ['PDF_id_declaracion'] = utf8_decode ( $_GET ['id_declaracion'] );
	
	if ($_GET ['tipo_reporte'] == 1){
		//header ( "location:PDFEjecGastoInv.php" );
	} else{
		header ( "location:XLSEjecGastoInv.php" );
	}
} else {
	$resp = new cls_manejo_mensajes ( true, "401" );
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje ();
	exit ();

}
?>