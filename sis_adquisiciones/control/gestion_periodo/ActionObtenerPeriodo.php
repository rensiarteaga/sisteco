<?php
/**
 * Nombre del archivo:	ActionObtenerPeriodo.php
 * Propósito:			Devolver la periodo siguiente 
 * Parámetros:			
 * Valores de Retorno:	periodo (número)
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		13-06-2008
 */
session_start();

include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionObtenerPeriodo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$var = new cls_middle("f_ad_get_periodo","");
	$var->exec_function();
	$salida = $var->salida;
	$periodo = $salida[0][0];
	
	/*$fecha_sep = explode('.',$hora);
	$hora= $fecha_sep[0];
*/
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('periodo', $periodo);
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
