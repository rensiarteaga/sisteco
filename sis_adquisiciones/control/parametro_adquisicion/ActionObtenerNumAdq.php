<?php
/**
 * Nombre del archivo:	ActionObtenerNumAdq.php
 * Propósito:			Devolver el num_doc de parametro_adq en funcion a tipo_doc y tipo_adq
 * Parámetros:			$tipo_doc, $tipo_adq
 * Valores de Retorno:	num_doc
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		18-06-2008
 */
session_start();

include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionObtenerNumAdq.php';


if (!isset($_SESSION['autentificado']))
{ 
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$res = $Custom->ObtenerNumDoc($tipo_doc, $tipo_adq);

	if($res)
	{
		//Forma el xml de salida para la vista
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',1);
		$xml->add_rama('ROWS');
		$xml->add_nodo('num_doc', $Custom->salida[0][0]);
		$xml->fin_rama();
		$xml->mostrar_xml();
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Error al obtener tipo de cambio";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit;
	}
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
