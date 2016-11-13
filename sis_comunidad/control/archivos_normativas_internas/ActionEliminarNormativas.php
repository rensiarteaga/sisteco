<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarNormativas.php
Propósito:				Permite eliminar registros de la tabla com_detalle_normativa
Tabla:					tad_tad_servicio
Parámetros:				$id_servicio


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-05-16 14:58:49
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();


include_once("../LibModeloAdministracionComunidad.php");

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = "ActionEliminarNormativas.php";

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
			$id_archivos_normativas = $_GET["id_archivos_normativas_$j"];
		}
		else
		{
			$id_archivos_normativas = $_POST["id_archivos_normativas_$j"];				
		}

		if ($id_archivos_normativas == "undefined" || $id_archivos_normativas == "")
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
			$res = $Custom-> EliminarArchivoNormativa($id_archivos_normativas);
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
	if($sortcol == "") $sortcol = "AN.id_archivos_normativas";
	if($sortdir == "") $sortdir = "ASC";
	if($criterio_filtro == "") $criterio_filtro = "AN.estado_registro=''activo'' and AN.id_archivos_normativas=$id_archivos_normativas ";//$criterio_filtro = "TIPSER.id_tipo_servicio=''$m_id_tipo_servicio''";
	
	$res = $Custom->ContarArchivoNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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