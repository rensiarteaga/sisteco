<?php
/**
 * Nombre del archivo:	ActionVerificarDetalleProceso.php
 * Propósito:			devuelve tru o false dependiendo de si la solicitud tiene detalles en algun proceso
 * Parámetros:			$id_solicitud
 * Valores de Retorno:	true o false
 * Autor:				Jaime Rivera Rojas
 * Fecha creación:		28-06-2008
 */
session_start();

include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionVerificarDevengado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	
	
	$res = $Custom -> VerificarDevengado($id_cotizacion);
	
	if($res) $valor= $Custom->salida[0]['resultado'];
	

	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('respuesta', $valor);
	$xml->add_nodo('mensaje', $Custom->salida[0]['mensaje']);
	$xml->add_nodo('importe', $Custom->salida[0]['importe']);
	$xml->add_nodo('tipo', $Custom->salida[0]['tipo']);
	$xml->add_nodo('id_gestion', $Custom->salida[0]['id_gestion']);
	$xml->add_nodo('gestion', $Custom->salida[0]['gestion']);
	$xml->add_nodo('moneda', $Custom->salida[0]['moneda']);
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
