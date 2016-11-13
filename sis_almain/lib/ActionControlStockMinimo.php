<?php

session_start();

include_once("../control/LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionObtenerGestion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	if(!isset($id_almacen) && !isset($id_item))
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Error de parametros, nose tiene definido el item y el almacen";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit;
	}
	

	$var = new cls_middle("alma.f_control_stocks",NULL,false);
	$var->add_param("'SOLIC'");
	$var->add_param($id_almacen);
	$var->add_param($id_item);
	
	$var->exec_query_sss();
	
	$salida = $var->salida;

	$res = explode('#@@@#',$salida[0][0]);

	$cant_disponible = $res[0];
	$stock_minimo = $res[1];
	
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('cantidad_disponible', $cant_disponible);
	$xml->add_nodo('stock_minimo', $stock_minimo);
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
