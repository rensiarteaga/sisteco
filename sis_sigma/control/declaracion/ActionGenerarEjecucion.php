<?php
/**
**********************************************************
Nombre de archivo:	    ActionGenerarEjecucion.php
Propósito:				Permite eliminar registros de la tabla tct_Declaracion
Tabla:					tct_tct_Declaracion
Parámetros:				$id_Declaracion


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-10-16 12:20:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../LibModeloSigma.php");

$Custom = new cls_CustomDBSigma();
$nombre_archivo = __FILE__;

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
			$id_declaracion = $_GET["id_declaracion_$j"];
		}
		else
		{
			$id_declaracion = $_POST["id_declaracion_$j"];				
		}

		if ($id_declaracion == "undefined" || $id_declaracion == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "Declaración inexistente.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación
			$res = $Custom-> GenerarEjecucion($id_declaracion);
			if(!$res)
			{
				/*$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;*/
				//Devuelve el XML de respueta
				$xml = new cls_manejo_xml('ROOT');
				$xml->add_nodo('TotalCount',1);
				$xml->add_rama('ROWS');
				$xml->add_nodo('error',1);
				$xml->add_nodo('mensaje_error',$Custom->salida[1]);
				$xml->add_nodo('origen',$Custom->salida[2]);
				$xml->add_nodo('proc',$Custom->salida[3]);
				$xml->add_nodo('nivel',$Custom->salida[4]);
				$xml->add_nodo('query',$Custom->query);
				$xml->fin_rama();
				$xml->mostrar_xml();
				exit;
			}
		}
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('error',0);
	$xml->add_nodo('mensaje',$Custom->salida[1]);
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