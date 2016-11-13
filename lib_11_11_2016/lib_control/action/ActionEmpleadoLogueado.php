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
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	
	if($_SESSION["ss_id_empleado"]===""){
	$xml->add_nodo('nombre',"null");
	}
	else{
	$xml->add_nodo('id_empleado',$_SESSION["ss_id_empleado"]);
	}
	
	
	$xml->add_nodo('nombre',$_SESSION["ss_nombre_empleado"]);
	$xml->add_nodo('materno',$_SESSION["ss_materno_empleado"]);
	$xml->add_nodo('paterno',$_SESSION["ss_paterno_empleado"]);
	/*
	$xml->add_nodo('id_empleado',"null");
	$xml->add_nodo('nombre',"zzzz");
	$xml->add_nodo('materno',"xxxx");
	$xml->add_nodo('paterno',"yyyyy");
	*/
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
