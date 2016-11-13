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
	$var = new cls_middle("f_ai_get_gestion","");
	$var->exec_function();
	$salida = $var->salida;
	$gestion = $salida[0][0];
	
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('gestion', $gestion);
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
