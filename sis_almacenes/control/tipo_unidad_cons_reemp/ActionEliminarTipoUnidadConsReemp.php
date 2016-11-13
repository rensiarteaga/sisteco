<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarTipoUnidadConsReemp.php
Propósito:				Permite eliminar registros de la tabla tal_tipo_unidad_cons_reemp
Tabla:					tal_tal_tipo_unidad_cons_reemp
Parámetros:				$hidden_id_tipo_unidad_cons_reemp


Valores de Retorno:    	Número de registros
Fecha de Creación:		2007-11-07 15:46:33
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../arv_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionEliminarTipoUnidadConsReemp.php";

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
			$hidden_id_tipo_unidad_cons_reemp = $_GET["hidden_id_tipo_unidad_cons_reemp_$j"];
		}
		else
		{
			$hidden_id_tipo_unidad_cons_reemp = $_POST["hidden_id_tipo_unidad_cons_reemp_$j"];				
		}

		if ($hidden_id_tipo_unidad_cons_reemp == "undefined" || $hidden_id_tipo_unidad_cons_reemp == "")
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
			$res = $Custom-> EliminarTipoUnidadConsReemp($hidden_id_tipo_unidad_cons_reemp);
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
	if($sortcol == "") $sortcol = "id_tipo_unidad_cons_reemp";
	if($sortdir == "") $sortdir = "asc";
	//if($criterio_filtro == "") $criterio_filtro = "TIPOUC.id_tipo_unidad_constructiva=''$maestro_id_tipo_unidad_constructiva''";
	if($criterio_filtro == "") $criterio_filtro = "TUCREEM.id_composicion_tuc=$id_composicion_tuc";
	
	$res = $Custom->ContarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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