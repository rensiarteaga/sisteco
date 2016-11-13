<?php

session_start();

include_once("../../rcm_LibModeloAlmacenes.php");
$nombre_archivo = 'ActionDiarioSalida.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$fecha_desde=$txt_fecha_desde;
	$fecha_hasta=$txt_fecha_hasta;
	$id_almacen=$txt_id_almacen;
	$id_supergrupo=$txt_id_supergrupo;
	
	$_SESSION['rep_dia_sal_fecha_desde']=$fecha_desde;
	$_SESSION['rep_dia_sal_fecha_hasta']=$fecha_hasta;
	$_SESSION['rep_dia_sal_id_almacen']=$id_almacen;
	$_SESSION['rep_dia_sal_id_supergrupo']=$id_supergrupo;
	header("location:PDFDiarioSalida.php");
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