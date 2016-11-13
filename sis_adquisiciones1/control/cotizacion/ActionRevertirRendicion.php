<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarCotizacion.php
Propósito:				Permite eliminar registros de la tabla tad_cotizacion
Tabla:					tad_tad_cotizacion
Parámetros:				$id_cotizacion


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-05-28 16:58:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();


include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionRevertirRendicion.php";

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

	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_cotizacion = $_GET["id_cotizacion_$j"];
		}
		else
		{
			$id_cotizacion = $_POST["id_cotizacion_$j"];				
		}

		if ($id_cotizacion == "undefined" || $id_cotizacion == "")
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
			$res = $Custom-> RevertirRendicion($id_cotizacion);
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
	}//end for

	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", "1");
	$resp->add_nodo("mensaje","Éxito");
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