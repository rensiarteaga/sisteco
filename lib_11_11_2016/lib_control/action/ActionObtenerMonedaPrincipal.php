<?php
/**
 * Nombre del archivo:	ActionObtenerMonedaPrincipal.php
 * Propósito:			Devolver la moneda especificada como principal
 * Parámetros:			
 * Valores de Retorno:	Moneda principal
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-06-2007
 */
session_start();

include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionObtenerMonedaPrincipal.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$var = new cls_middle("f_pm_get_moneda_principal","");
	$var->exec_function();
	$salida = $var->salida;
	$id_moneda = $salida[0][0];//devuelve id_moneda_base
	
	
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('id_moneda', $id_moneda);
	$xml->fin_rama();
	$xml->mostrar_xml();

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
