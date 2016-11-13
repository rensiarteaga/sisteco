<?php
/**
**********************************************************
Nombre de archivo:	    ActionCorrigeResumen.php
Propósito:				Permite eliminar registros de la tabla tkp_resumen_horario_mes
Tabla:					tkp_resumen_horario_mes
Parámetros:				$hidden_id_resumen_horario_mes


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();

include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionAprobarSolicitudLicenciaDetphp";

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
			$id_horario = $_GET["hidden_id_horario_0"];
			$m_id_vacacion=$_GET["m_id_vacacion"];
			$tipo = $_GET["tipo"];
		}
		else
		{
			$id_horario = $_POST["hidden_id_horario_0"];
			$m_id_vacacion=$_POST["m_id_vacacion"];
			$tipo = $_POST["tipo"];
		}	
		
		if ($id_horario == "undefined" || $id_horario == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación
			$res = $Custom-> FinalizaSolicitudLicencia($id_horario,$tipo);
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
	if($cont>1) $mensaje_exito = "Se cargo el resumen de marcas";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "HORARI.fecha_inicio";
	if($sortdir == "") $sortdir = "asc";
	
	$criterio_filtro="HORARI.id_vacacion = ".$m_id_vacacion;
			
	$res = $Custom->ContarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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