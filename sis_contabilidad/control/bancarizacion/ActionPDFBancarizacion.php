<?php
session_start();
include_once("../LibModeloContabilidad.php");
$nombre_archivo='ActionPDFBancarizacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			$id_bancarizacion=$id_bancarizacion;
			$tipo_operacion=$tipo_operacion;
			$_SESSION['operacion_bancarizacion_det']=$tipo_operacion;
			 header("location:PDFBancarizacion.php?id_bancarizacion=".$id_bancarizacion."&tipo_operacion=".$tipo_operacion); 			
}
else
{
	$resp=new cls_manejo_mensajes(true,"401");
	$resp->mensaje_error='MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen="ORIGEN = $nombre_archivo";
	$resp->proc="PROC = $nombre_archivo";
	$resp->nivel='NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>