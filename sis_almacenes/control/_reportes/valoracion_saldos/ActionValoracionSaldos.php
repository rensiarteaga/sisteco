<?php

session_start();

include_once("../../LibModeloAlmacenes.php");
$nombre_archivo = 'ActionValoracionSaldos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$data="fecha=$fecha";
	$data.="&id_financiador=$txt_id_financiador";
	$data.="&id_regional=$txt_id_regional";
	$data.="&id_programa=$txt_id_programa";
	$data.="&id_proyecto=$txt_id_proyecto";
	$data.="&id_actividad=$txt_id_actividad";
	$data.="&id_parametro_almacen=$txt_id_parametro_almacen";
	$data.="&id_almacen=$txt_id_almacen";
	$data.="&id_almacen_logico=$txt_id_almacen_logico";
	
	
	header("location:PDFValoracionSaldos.php?".$data);
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