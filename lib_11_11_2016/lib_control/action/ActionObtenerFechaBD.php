<?php
/**
 * Nombre del archivo:	ActionObtenerTipoCambio.php
 * Propósito:			Devolver el tipo de cambio de una moneda en función de otra en una fecha específica
 * Parámetros:			$fecha, $id_moneda1, $id_moneda2, $tipo
 * Valores de Retorno:	Tipo de cambio (número)
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-06-2007
 */
session_start();

include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionObtenerTipoCambio.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$var = new cls_middle("f_pm_get_fecha_bd","");
	$var->exec_function();
	$salida = $var->salida;
	$fecha = $salida[0][0];//devuelve yyyy-mm-dd
	
	$fecha_sep = explode('-',$fecha);
	$fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];

/*	$rr= new DateTime($fecha);
	$fecha = $rr->format("d/m/Y");*/

	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('fecha', $fecha);
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
