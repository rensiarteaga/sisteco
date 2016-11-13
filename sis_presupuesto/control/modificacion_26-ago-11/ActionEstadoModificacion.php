<?php
/**
**********************************************************
Nombre de archivo:	    ActionEstadoModificacion.php
Propósito:				Permite eliminar registros de la tabla tts_cuenta_doc
Tabla:					tts_tts_cuenta_doc
Parámetros:				$id_depto


Valores de Retorno:    	Número de registros
Fecha de Creación:		2009-10-27 10:40:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = "ActionEstadoModificacion.php";

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
		$cont=1;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Cambiar Estado.";
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
			$id_modificacion = $_GET["id_modificacion"];
			$accion = $_GET["accion"];
			
			
			/*echo "accion:".$accion."<br>";
			echo "id_cuenta_bancaria:".$id_cuenta_bancaria."<br>";
			exit;*/
			
		}
		else
		{
			$id_modificacion = $_POST["id_modificacion"];
			$accion = $_POST["accion"];			
		}

		if ($id_modificacion == "undefined" || $id_modificacion == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado para Cambiar Estado.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	
			
			$res = $Custom-> CambiarEstadoModificacion($id_modificacion,$accion);
			//echo var_dump($Custom); exit;
			
			if(!$res)
			{
				
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
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = "Se cambio el estado de los registros especificados.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_modificacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") 
	{
		if($fk_id_cuenta_doc!='0')
			$criterio_filtro = "MODIFI.id_modificacion=$id_modificacion";
		else 
			$criterio_filtro = "0=0";
	}

	$res = $Custom->ContarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
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