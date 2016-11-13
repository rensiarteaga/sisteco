<?php 
/*
**********************************************************
Nombre de archivo:	    ActionEliminarAdjunto.php
Propósito:				Permite eliminar registros de la tabla tfl_adjunto
Tabla:					tfl_adjunto
Parámetros:				

Valores de Retorno:    	
Fecha de Creación:		2010-12-22
Versión:				1.0.0
Autor:					Marcos A. Flores Valda
**********************************************************
*/
 
session_start();

include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionEliminarAdjunto.php";

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
		$id_adjunto = $_POST["id_adjunto_0"];

		$id_proyecto = $_GET["id_proyecto"];		

		if ($id_adjunto == "undefined" || $id_adjunto == "")
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
		{	
			$ext = explode(".",$_FILES["archivo_adjunto"]["name"]); //obtiene cadena despues del .
						
			$tamaño = count($ext);
				
			$extension = $ext[$tamaño - 1]; // se obtiene la extension = ultimo indice del vector
		
			$nombre_arch = 'adjunto_';
		
			//Eliminación
			$res = $Custom-> EliminarAdjunto($id_adjunto);
						
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
			else
			{			
				 $extension = $Custom->salida[2];
				 $adjunto = $nombre_arch.$id_adjunto.'.'.$extension;	
				 unlink('../../control/adjunto/arch_adjuntos/'.$adjunto);				
			}
		}
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) 
		$mensaje_exito = "Se eliminaron los registros especificados.";
	
	else 
		$mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_adjunto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";
		
//	if(isset($id_proyecto))
//		$criterio_filtro = $id_proyecto;
	$criterio_filtro.=" and ADJUNT.id_proyecto=$id_proyecto";
		
	$res = $Custom -> ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_proyecto);
			
	if($res) 
		$total_registros = $Custom->salida;

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