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

include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionMarcarRendiciones.php';

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
	
	
	$res = $Custom -> MarcarRendiciones2($id_cuenta_doc);

	

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount","1");
	$resp->add_nodo("mensaje",$mensaje_exito = $Custom->salida[1]);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;

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
