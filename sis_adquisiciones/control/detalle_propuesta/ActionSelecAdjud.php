<?php 
/**
**********************************************************
Nombre de archivo:	    ActionEliminarDetallePropuesta.php
Propósito:				Permite eliminar registros de la tabla tad_detalle_propuesta
Tabla:					tad_tad_detalle_propuesta
Parámetros:				$id_detalle_propuesta


Valores de Retorno:    	Número de registros
Fecha de Creación:		2009-02-03 11:26:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();


include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "SelecAdjDetallePropuesta.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	if (sizeof($_GET) >0)
	{
		$get=true;
		$cont=1;
	}
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST["cantidad_ids"];
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}


	if ($get)
	{
		$id_detalle_propuesta = $_GET["id_detalle_propuesta"];
		$id_cotizacion_det = $_POST["id_cotizacion_det"];
	}
	else
	{
		$id_detalle_propuesta = $_POST["id_detalle_propuesta"];
		$id_cotizacion_det = $_POST["id_cotizacion_det"];
	}

	if ($id_detalle_propuesta == "undefined" || $id_detalle_propuesta == "")
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado para seleccionar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	else
	{	//Eliminación
		$res = $Custom-> SelecAdjDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}


	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = "Seleccion exitosa.";
	else $mensaje_exito = $Custom->salida[2];



	echo "{success:true,mensaje:'$mensaje_exito'}";
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