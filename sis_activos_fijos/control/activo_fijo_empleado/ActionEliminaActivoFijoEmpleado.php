<?php
/*
/*
**********************************************************
Nombre de archivo:	    ActionEliminaActivoFijoEmpleado.php
Propósito:				Permite eliminar registros de la tabla de Activo_fijo_empleado
Tabla:					taf_activo_fijo_empleado
Parámetros:				$hidden_id_activo_fijo_empleado	--> id de Activo_fijo_empleado
$txt_id_usuario_asignacion

Valores de Retorno:    	Número de registros
Fecha de Creación:		06 - 06 - 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero M.
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionEliminaActivoFijoEmpleado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	if (sizeof($_GET) >0)
	{
		$get=true;
		$cont=1;
	}
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
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
			$hidden_id_activo_fijo_empleado = $_GET["hidden_id_activo_fijo_empleado_$j"];
			
		}
		else
		{
			$hidden_id_activo_fijo_empleado = $_POST["hidden_id_activo_fijo_empleado_$j"];
			
		}

		if ($hidden_id_activo_fijo_empleado == "undefined" || $hidden_id_activo_fijo_empleado ==" ")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe activo_fijo_empleado especificada para eliminar.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
		}
		else
		{	//Eliminación
			
			$res = $Custom-> EliminarActivoFijoEmpleado($hidden_id_activo_fijo_empleado);
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
	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'estados';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';
	//if($criterio_filtro == "") $criterio_filtro = "afe.id_activo_fijo_empleado = $hidden_id_activo_fijo_empleado";

	$res = $Custom->ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;
	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje',$mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
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



