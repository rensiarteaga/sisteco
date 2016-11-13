<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProcesoCompraMulDet.php
Propósito:				Permite insertar y modificar datos en la tabla tad_proceso_compra_det
Tabla:					tad_tad_proceso_compra_det
Parámetros:				$id_proceso_compra_det
						$id_servicio
						$id_item
						$cantidad
						$precio_referencial_total
						$id_proceso_compra
						$estado_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-20 17:42:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarProcesoCompraMulDet.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	if($agrupar=='SI'){
		
		$res = $Custom ->AgrupaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det);
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
		

		$mensaje_exito = $Custom->salida[1];
		echo "{success:true,agrupar:'NO',mensaje:'$mensaje_exito'}";
		exit;


	}
	if($agrupar=='NO'){
		
		$res = $Custom ->InsertaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det);
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
		

		$mensaje_exito = $Custom->salida[1];
		echo "{success:true,agrupar:'NO',mensaje:'$mensaje_exito'}";
		exit;

	}
	if (!isset($agrupar))
	{
		$res = $Custom -> VerificarInsertarProcesoCompraMulDet($id_proceso_compra_det, $id_servicio, $id_item, $cantidad, $precio_referencial_total, $id_proceso_compra, $estado_reg,$id_solicitud_compra_det);

		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
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

		echo "{success:true,agrupar:'$agrupar',mensaje:'$mensaje_exito'}";
		exit;
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