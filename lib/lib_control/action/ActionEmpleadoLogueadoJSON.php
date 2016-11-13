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
$nombre_archivo = 'ActionEmpleadoLogueado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$id_emp=$_SESSION["ss_id_empleado"];
	if($id_emp===""){
		$id_emp='null';
	}
		
		
	echo "{id_empleado:$id_emp}";
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
