<?php 
/**
**********************************************************
Nombre de archivo:	    ActionEliminarDocumento.php
Propósito:				Permite eliminar registros de la tabla tct_documento
Tabla:					tct_tct_documento
Parámetros:				$id_documento


Valores de Retorno:    	Número de registros
Fecha de Creación:		16/02/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();

include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionEliminarDocumento.php";

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
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Eliminar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}


	if ($id_documento == "undefined" || $id_documento == "")
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado para eliminar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	else
	{	//Eliminación
		$res = $Custom-> EliminarDocumento($id_documento,$nombre_tabla,$nombre_campo,$id_tabla);
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
	if($cont>1) $mensaje_exito = "Se eliminaron los registros especificados.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_documento";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	//$res = $Custom->ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	//if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
	$resp->add_nodo("mensaje",$mensaje_exito);
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