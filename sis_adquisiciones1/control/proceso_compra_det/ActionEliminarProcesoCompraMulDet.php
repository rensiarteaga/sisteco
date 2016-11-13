<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarProcesoCompraMulDet.php
Propósito:				Permite eliminar registros de la tabla tad_proceso_compra_det
Tabla:					tad_tad_proceso_compra_det
Parámetros:				$id_proceso_compra_det


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-05-20 17:42:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();


include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionEliminarProcesoCompraMulDet.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	$res = $Custom -> EliminarProcesoCompraMulDet($id_solicitud_compra_det,$id_proceso_compra);

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

		//Guarda el mensaje de éxito de la operación realizada
		
		$mensaje_exito = $Custom->salida[1];

		$agrupar=$Custom->salida[2];

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