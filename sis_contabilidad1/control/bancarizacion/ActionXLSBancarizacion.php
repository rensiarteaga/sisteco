<?php
session_start ();
include_once ("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad ( );
$nombre_archivo = 'ActionXLSBancarizacion.php';

if (! isset ( $_SESSION ['autentificado'] )) {
	$_SESSION ['autentificado'] = "NO";
}

if ($_SESSION ['autentificado'] == "SI") {
	$cant = 100000;
	$puntero = 0;
	$sortcol = '';
	$sortdir = 'asc';
	
	$id_bancarizacion=$id_bancarizacion;
	$tipo_operacion=$tipo_operacion;
	$_SESSION['operacion_bancarizacion_det']=$tipo_operacion;
	
	header("location:XLSBancarizacion.php?id_bancarizacion=".$id_bancarizacion."&tipo_operacion=".$tipo_operacion);
	 
	/*$_SESSION ['PDF_id_bancarizacion'] = utf8_decode ( $_GET ['id_bancarizacion'] );
	$_SESSION ['PDF_id_bancarizacion'] = utf8_decode ( $_GET ['id_bancarizacion'] );
	header ( "location:XLSBancarizacion.php" );*/
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