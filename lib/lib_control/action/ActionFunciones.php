<?php
/**
 * Nombre del archivo:	ActionFunciones.php
 * Propósito:			Libreria de funcione
 * Parámetros:			$funcion
 * Valores de Retorno:	$_xml 
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 */
session_start();

//include_once("../../configuracion.inc.php");
include_once("../../lib_general/cls_funciones.php");
//include_once("../../lib_general/cls_archivos.php");
//include_once("../../lib_general/cls_conexion.php");
//include_once("../../lib_general/cls_middle.php");
//include_once("../..lib_general/cls_define_tipo_dato.php");
include_once("../cls_manejo_xml.php");
include_once("../cls_manejo_mensajes.php");

$nombre_archivo = 'ActionFunciones.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	switch ($funcion) {
		case "fecha":
			{
				$fecha=date("Y-m-d");
				$hora = date('H:i:s');

				$resp = new cls_manejo_mensajes(false, "202");
				$resp -> add_nodo('fecha',"$fecha $hora");
				$resp->get_mensaje();
				exit;
				break;
			}
		default:{
			$resp = new cls_manejo_mensajes(true, "401");
			$resp->mensaje_error = "MENSAJE ERROR = La funcion no fue definida $funcion";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 1";
			echo $resp->get_mensaje();
			exit;
			break;
		}

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
