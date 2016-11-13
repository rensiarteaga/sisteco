<?php

session_start();

include_once("../../LibModeloPresupuesto.php");
$nombre_archivo = 'ActionPDFEjecucionFisica.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	/*echo 'El valor del id es: '.  $id_ejecucion_fisica;
	exit();*/

	header("location:PDFEjecucionFisica.php?id_ejecucion_fisica=$id_ejecucion_fisica");
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