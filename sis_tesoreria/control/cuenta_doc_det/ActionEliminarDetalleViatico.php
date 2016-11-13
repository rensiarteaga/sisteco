<?php 
/**
**********************************************************
Nombre de archivo:	    ActionEliminarDetalleViatico.php
Propósito:				Permite eliminar registros de la tabla tts_cuenta_doc_det
Tabla:					tts_tts_cuenta_doc_det
Parámetros:				$id_concepto_ingas


Valores de Retorno:    	Número de registros
Fecha de Creación:		2009-10-27 10:40:43
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();


include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionEliminarDetalleViatico.php";

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
			$id_cuenta_doc_det = $_GET["id_cuenta_doc_det_$j"];
		}
		else
		{
			$id_cuenta_doc_det = $_POST["id_cuenta_doc_det_$j"];				
		}

		if ($id_cuenta_doc_det == "undefined" || $id_cuenta_doc_det == "")
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
			$res = $Custom-> EliminarDetalleViatico($id_cuenta_doc_det);
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

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = "Se eliminaron los registros especificados.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cuenta_doc_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "CUDOC.id_cuenta_doc=$id_cuenta_doc";
	if($m_id_cuenta_doc_rendicion!=''){
		$criterio_filtro = "CUEREN.id_cuenta_doc_rendicion=''$m_id_cuenta_doc_rendicion''";
	}
	
	$res = $Custom->ContarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
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