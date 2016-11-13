<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProcesoCompra.php
Propósito:				Para pasar al esta de proceso_compra "en_proceso", en estado se inicia el proceso
Tabla:					tad_tad_proceso_compra
Parámetros:				$id_proceso_compra
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-13 18:03:05
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarProcesoCompra.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{

		if ($id_proceso_compra != "undefined" && $id_proceso_compra != "")
		{
			////////////////////Inserción/////////////////////
			
			//Validación satisfactoria, se ejecuta  el incio de proceso
			$res = $Custom -> IniciarProcesoCompra($id_proceso_compra,"Transcurso Regular");

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
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