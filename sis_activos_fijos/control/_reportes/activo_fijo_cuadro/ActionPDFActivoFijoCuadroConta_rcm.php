<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoCuadro.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$id_financiador            =  $hidden_id_financiador;
	$id_regional               =  $hidden_id_regional;
	$id_programa               =  $hidden_id_programa;
	$id_proyecto               =  $hidden_id_proyecto;
	$fecha                     =  $txt_fecha;
	$id_auxiliar               =  $hidden_id_auxiliar;
	$tipo_rep				   =  $txt_tipo_rep;

	$_SESSION['rep_af_cuad_conta_fecha']=substr($txt_fecha,3,2).'/'.substr($txt_fecha,0,2).'/'.substr($txt_fecha,6,4);

	if($tipo_rep=='det'){
		header("location:PDFActivoFijoCuadroConta.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&fecha=$fecha&id_auxiliar=$id_auxiliar&tipo_rep=$tipo_rep");
	}
	else{
		header("location:PDFActivoFijoCuadroContaTotales.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&fecha=$fecha&id_auxiliar=$id_auxiliar&tipo_rep=$tipo_rep");
	}

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

}