<?php
/**
**********************************************************
Nombre de archivo:	    ActionCorrigeResumen.php
Prop�sito:				Permite eliminar registros de la tabla tkp_resumen_horario_mes
Tabla:					tkp_resumen_horario_mes
Par�metros:				$hidden_id_resumen_horario_mes


Valores de Retorno:    	N�mero de registros
Fecha de Creaci�n:		2008-05-12 09:24:17
Versi�n:				1.0.0
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
			$id_vacacion = $_GET["hidden_id_vacacion_0"];
			$id_tipo_horario = $_GET["hidden_id_tipo_horario_0"];
			$id_empleado = $_GET["hidden_id_empleado_0"];
			$id_empleado_aprobacion = $_GET["hidden_id_empleado_aprobacion_0"];
			$num_solicitud=$_GET["m_num_solicitud"];
			$tipo = $_GET["tipo"];
		}
		else
		{
			$id_vacacion = $_POST["hidden_id_vacacion_0"];
			$id_tipo_horario = $_POST["hidden_id_tipo_horario_0"];
			$id_empleado = $_POST["hidden_id_empleado_0"];
			$id_empleado_aprobacion = $_POST["hidden_id_empleado_aprobacion_0"];
			$num_solicitud=$_POST["m_num_solicitud"];
			$tipo = $_POST["tipo"];
		}

		if ($id_vacacion == "undefined" || $id_vacacion == "")
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
		{	//Eliminaci�n
			$res = $Custom-> AprobarSolicitudLicenciaDet($id_vacacion,$id_tipo_horario,$id_empleado,$id_empleado_aprobacion,$tipo,$num_solicitud);
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
	
	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont>1) $mensaje_exito = "Se cargo el resumen de marcas";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "HORARI.id_tipo_horario";
	if($sortdir == "") $sortdir = "asc";
	if($tipo=='aprueba' || $tipo=='corrige'){
		$criterio_filtro="VACACI.id_empleado_aprobacion=".$_SESSION["ss_id_empleado"]." AND HORARI.estado_reg=''pendiente_aprobacion''   
		                                    GROUP BY HORARI.id_tipo_horario,VACACI.id_empleado,EMPLEA.nombre_completo,TIPHOR.nombre,HORARI.id_empleado_aprobacion,HORARI.id_vacacion";
	}
	else{
		$criterio_filtro="0=0 AND (HORARI.estado_reg=''aprobado'' OR HORARI.estado_reg=''en_proceso'')   
		                                    GROUP BY HORARI.id_tipo_horario,VACACI.id_empleado,EMPLEA.nombre_completo,TIPHOR.nombre,HORARI.id_empleado_aprobacion,HORARI.id_vacacion";
	}
	$res = $Custom->ContarAprobarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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