<?php
/*
**********************************************************
Nombre de archivo:	    ActionEliminarTipoActivoCuenta.php
Propósito:				Permite eliminar registros de la tabla de actif.taf_tipo_activo_cuenta
Tabla:					actif.taf_tipo_activo_cuenta
Parámetros:				$id_tipo_activo_cuenta


Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versión:				
Autor:					
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionEliminarTipoActivoCuenta.php';

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
		$resp->mensaje_error = "No existen datos para Eliminar.";
		$resp->origen = $nombre_archivo;
		$resp->proc = $nombre_archivo;
		$resp->nivel = '4';
		echo $resp->get_mensaje();
		exit;
	}


	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_tipo_activo_cuenta = $_GET["id_tipo_activo_cuenta_$j"];

		}
		else
		{
			$id_tipo_activo_cuenta= $_POST["id_tipo_activo_cuenta_$j"];

		}
		if ($id_tipo_activo_cuenta == "undefined" || $id_tipo_activo_cuenta==" ")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = El registro especificado no existe en la BD.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación


			$res = $CustomActivos ->EliminarTipoActivoCuenta($id_tipo_activo_cuenta);

			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;

			}
		}
	}//end for

	//Guarda el mensaje de éxito de la operación realizada

	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $CustomActivos->salida[1];



	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $CustomActivos->CountTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros = $CustomActivos->salida;// talves haya que modificar por salida;

	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
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



