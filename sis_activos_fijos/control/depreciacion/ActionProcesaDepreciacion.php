<?php
/**
 * Nombre del archivo:	ActionEliminaDepreciacion.php
 * Propósito:			Permite eliminar registros de Depreciaciones
 * Tabla:				taf_depreciacion
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		08-06-2007
 */
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionEliminaDepreciacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	if($error == 'si')
	{
		$resp = new cls_manejo_mensajes(false,'200');
		$resp->add_nodo('mensaje','El proceso fue ejecutado con exito');
		$resp->add_nodo('tiempo_resp', '200');
		$resp->get_mensaje();
		exit;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "503");
		$resp->mensaje_error = "MENSAJE ERROR = No se pudo realizar el proceso";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		$resp->get_mensaje();
		exit;

	}
	//Arma el xml para desplegar el mensaje

}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>



