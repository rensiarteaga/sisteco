<?php
/**
**********************************************************
Nombre de archivo:	    ActionGenerarSalidaPendiente.php
Propósito:				Permite eliminar registros de la tabla tal_parametro_almacen
Tabla:					tal_tal_parametro_almacen
Parámetros:				$hidden_id_parametro_almacen_logico



Fecha de Creación:		06/12/2016
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();

include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionCerrarGestion.php";

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
			$hidden_id_pedido_tuc_int = $_GET["hidden_id_salida"];
		}
		else
		{
			$hidden_id_pedido_tuc_int = $_POST["hidden_id_salida"];				
		}

		if ($hidden_id_pedido_tuc_int == "undefined" || $hidden_id_salida == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado cerrar gestión.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación
			$res = $Custom-> GenerarSalidaPendiente($hidden_id_salida);
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
	if($cont>1) $mensaje_exito = "Se cerro la gestión especificada";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_pedido_tuc_int";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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