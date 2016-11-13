<?php
/**
 * Nombre del archivo:	ActionConvertirMonedas.php
 * Propósito:			Devolver el monto convertido de la moneda 1 a la moneda 2 en una fecha específica
 * Parámetros:			$fecha, $monto, $id_moneda1, $id_moneda2, $tipo
 * Valores de Retorno:	Monto convertido expresado en moneda2 (número)
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-06-2007
 */
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionConvertirMonedas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	//Da formato a la fecha recibida
	$fecha_sep = explode('/',$fecha);
	$fecha = $fecha_sep[1]."/".$fecha_sep[0]."/".$fecha_sep[2];

	//Obtiene el tipo de cambio
	$res = $Custom->ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo);
	
	if($res)
	{
		//Forma el xml de salida para la vista
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',1);
		$xml->add_rama('ROWS');
		$xml->add_nodo('monto', $Custom->salida[0][0]);
		$xml->fin_rama();
		$xml->mostrar_xml();
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		if($Custom->salida[1]=='')
		{
			$resp->mensaje_error = "MENSAJE ERROR = Error al obtener tipo de cambio";
		}
		else
		{
			$resp->mensaje_error = $Custom->salida[1] ;
		}
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
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
